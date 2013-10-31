<?php
// currently not supported
if(php_sapi_name() == 'cli')
{
	return;
}

// check for an app specific config which may override the global config:
$appConfig = array();

// Walk up the fielpath up to the DOCUMENT_ROOT to find the optional app config file
// First file found on the path will be used
$fileServed = $_SERVER['SCRIPT_FILENAME'];
$dir = dirname($fileServed);
do {
    $cfgFile = $dir .DIRECTORY_SEPARATOR. 'xhprof.inc.php';
    
    if (file_exists($cfgFile)) {
        $appConfig = require $cfgFile;
        break;
    }
    
    $dir = dirname($dir);
} while (!empty($dir) && stripos($dir, $_SERVER["DOCUMENT_ROOT"]) !== false);

// disabled by app-config?
if (isset($appConfig['enabled']) && !$appConfig['enabled']) {
    define ('XHPROF_ENABLED', 0);
    return;
}

$xhprofMainConfig = require __DIR__ . '/../xhprof/includes/config.inc.php';

// check the global enable switch, but only when no app-config enable switch was defined
if (!isset($appConfig['enabled']) && isset($xhprofMainConfig['profiler_enabled']) && !$xhprofMainConfig['profiler_enabled']) {
    define ('XHPROF_ENABLED', 0);
    return;
}

define ('XHPROF_ENABLED', 1);

xhprof_enable(XHPROF_FLAGS_MEMORY | XHPROF_FLAGS_CPU);