<?php

class AuditLogger
{
    private $logFile;
    private $dryRun;

    public function __construct($dryRun = false)
    {
        $this->dryRun = $dryRun;
        $this->logFile = __DIR__ . '/logs/audit.log';

        // Ensure log directory exists
        if (!file_exists(dirname($this->logFile))) {
            mkdir(dirname($this->logFile), 0755, true);
        }
    }

    public function log($event, $details = [])
    {
        $entry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'event' => $event,
            'mode' => $this->dryRun ? 'DRY_RUN' : 'EXECUTE',
            'details' => $details
        ];

        $line = json_encode($entry) . PHP_EOL;

        // Write to log file
        file_put_contents($this->logFile, $line, FILE_APPEND);

        // Output to stdout ONLY for CLI (not web requests)
        if (php_sapi_name() === 'cli') {
            echo "[" . $entry['timestamp'] . "] [" . $entry['mode'] . "] " . $event . ": " .
                ($details['message'] ?? json_encode($details)) . PHP_EOL;
        }
    }
}
