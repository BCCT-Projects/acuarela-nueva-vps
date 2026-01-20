<?php
// Prevent web access (double check, though .htaccess handles this)
if (php_sapi_name() !== 'cli') {
    die('Access denied. This script can only be run from the command line.');
}

require_once __DIR__ . '/RetentionJob.php';

// Parse arguments
$dryRun = false;
foreach ($argv as $arg) {
    if ($arg === '--dry-run') {
        $dryRun = true;
    }
}

echo "Starting Retention Job...\n";
if ($dryRun) {
    echo "MODE: DRY RUN (No files will be deleted)\n";
} else {
    echo "MODE: EXECUTE (Files WILL be deleted)\n";
    // Small safety delay
    sleep(3);
}

$job = new RetentionJob($dryRun);
$job->run();

echo "\nDone.\n";
