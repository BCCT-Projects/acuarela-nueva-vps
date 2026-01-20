<?php
require_once __DIR__ . '/AuditLogger.php';

class RetentionJob
{
    private $logger;
    private $rulesFile;
    private $dryRun;

    public function __construct($dryRun = false)
    {
        $this->dryRun = $dryRun;
        $this->logger = new AuditLogger($dryRun);
        $this->rulesFile = __DIR__ . '/retention_rules.json';
    }

    public function run()
    {
        $this->logger->log('JOB_STARTED', ['message' => 'Starting retention job']);

        if (!file_exists($this->rulesFile)) {
            $this->logger->log('ERROR', ['message' => 'Rules file not found: ' . $this->rulesFile]);
            return;
        }

        $rules = json_decode(file_get_contents($this->rulesFile), true);
        if (!$rules) {
            $this->logger->log('ERROR', ['message' => 'Invalid JSON in rules file']);
            return;
        }

        foreach ($rules as $rule) {
            $this->processRule($rule);
        }

        $this->logger->log('JOB_COMPLETED', ['message' => 'Retention job finished']);
    }

    private function processRule($rule)
    {
        $this->logger->log('RULE_START', ['rule' => $rule['name']]);

        try {
            if ($rule['type'] === 'file') {
                $this->processFileRule($rule);
            } else {
                $this->logger->log('RULE_SKIPPED', ['rule' => $rule['name'], 'reason' => 'Unknown rule type']);
            }
        } catch (Exception $e) {
            $this->logger->log('RULE_ERROR', ['rule' => $rule['name'], 'error' => $e->getMessage()]);
        }
    }

    private function processFileRule($rule)
    {
        // Resolve path relative to this script location
        // Base path is members/cron/, so "../../" goes to root
        $basePath = __DIR__ . '/';
        $pattern = $basePath . $rule['path'];

        $files = glob($pattern);

        if ($files === false) {
            $this->logger->log('RULE_WARNING', ['rule' => $rule['name'], 'message' => 'Glob returned false (check permissions or path)']);
            return;
        }

        $count = 0;
        $deleted = 0;
        $cutoffTime = time() - ($rule['retention_days'] * 86400);

        foreach ($files as $file) {
            if (!is_file($file))
                continue;

            $mtime = filemtime($file);
            if ($mtime < $cutoffTime) {
                $count++;
                if ($this->dryRun) {
                    $this->logger->log('ITEM_CANDIDATE', [
                        'rule' => $rule['name'],
                        'file' => basename($file),
                        'age_days' => round((time() - $mtime) / 86400, 1)
                    ]);
                } else {
                    if (unlink($file)) {
                        $deleted++;
                        $this->logger->log('ITEM_DELETED', ['file' => basename($file)]);
                    } else {
                        $this->logger->log('ITEM_ERROR', ['file' => basename($file), 'message' => 'Could not delete']);
                    }
                }
            }
        }

        $this->logger->log('RULE_SUMMARY', [
            'rule' => $rule['name'],
            'analyzed' => count($files),
            'candidates' => $count,
            'deleted' => $deleted
        ]);
    }
}
