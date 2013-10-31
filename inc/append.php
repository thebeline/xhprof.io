<?php
// CLI environment is currently not supported
if(php_sapi_name() == 'cli' || defined('XHPROF_ENABLED') && !XHPROF_ENABLED)
{
	return;
}

register_shutdown_function(function(){
    global $xhprofMainConfig;
    
	// by registering register_shutdown_function at the end of the file
	// I make sure that all execution data, including that of the earlier
	// registered register_shutdown_function, is collected.

	$xhprof_data	= xhprof_disable();

	if(function_exists('fastcgi_finish_request'))
	{
		fastcgi_finish_request();
	}
		
    try {
		require_once __DIR__ . '/../xhprof/classes/data.php';
		
        $xhprof_data_obj	= new \ay\xhprof\Data($xhprofMainConfig['pdo']);
    	$xhprof_data_obj->save($xhprof_data);
    } catch (Exception $e) {
        // old php versions don't like Exceptions in shutdown functions
        // -> log them to have some usefull info in the php-log
        if (PHP_VERSION_ID < 504000) {
            if (function_exists('log_exception')) {
                log_exception($e);
            } else {
                error_log($e->__toString());
            }
        }
        // re-throw to show the caller something went wrong
        throw $e;
    }
});