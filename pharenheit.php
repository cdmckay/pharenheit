<?php

ob_clean();

$script_path = $_SERVER['SCRIPT_FILENAME'];
$script_dir = pathinfo($script_path, PATHINFO_DIRNAME);
$script_filename = pathinfo($script_path, PATHINFO_BASENAME);

// Check if the .phnheit file exists.
$php_path = realpath($script_dir) . DIRECTORY_SEPARATOR . basename($script_filename, '.phn') . '.php';
if (file_exists($php_path)) {
    require_once $php_path;
    exit;
}

$pharen_home = getenv('PHAREN_HOME');
if ($pharen_home === false) {
    $pharen_home = getenv('HTTP_PHAREN_HOME');
    if ($pharen_home == false) {
        error_log('PHAREN_HOME and HTTP_PHAREN_HOME not set');
        exit;
    }
}

require_once $pharen_home . DIRECTORY_SEPARATOR . 'pharen.php';
compile_lang();
compile_file($script_path);
require_once $php_path;

ob_end_flush();
exit;
