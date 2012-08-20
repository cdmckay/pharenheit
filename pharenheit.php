<?php

ob_clean();

if (!function_exists('pharenheit')) {
    function pharenheit() {
        $included_paths = get_included_files();
        $reversed_included_paths = array_reverse($included_paths);
        foreach ($reversed_included_paths as $path) {
            if (pathinfo($path, PATHINFO_EXTENSION) === "phn") {
                $script_path = $path;
                break;
            }
        }
        $script_dir = pathinfo($script_path, PATHINFO_DIRNAME);
        $script_filename = pathinfo($script_path, PATHINFO_BASENAME);

        // Check if the .php file exists.
        $php_path = realpath($script_dir) . DIRECTORY_SEPARATOR . basename($script_filename, '.phn') . '.php';
        if (file_exists($php_path) && filemtime($script_path) === filemtime($php_path)) {
            return $php_path;
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

        // Update modified time of .php file to match .phn file.
        $modified_time = filemtime($script_path);
        touch($php_path, $modified_time);

        return $php_path;
    }
}
require pharenheit();

ob_flush();

