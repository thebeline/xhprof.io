<?php
// currently not supported
if (php_sapi_name() != 'cli' && extension_loaded('xhprof') ) {
	function xhprof_shutdown() {

		$xhprof_data = xhprof_disable();
		
		if(function_exists('fastcgi_finish_request'))
		{
			fastcgi_finish_request();
		}
		
		$config = require __DIR__ . '/../xhprof/includes/config.inc.php';
		
		require_once __DIR__ . '/../xhprof/classes/data.php';
		
		$xhprof_data_obj	= new \ay\xhprof\Data($config['pdo']);
		$xhprof_data_obj->save($xhprof_data);
		
	}
	// The following registers an anonymous shutdown function that then registers another (end of stack)
	// shutdown function that calls our actual function.  Ensuring we run absolutely last.
	register_shutdown_function(create_function('','register_shutdown_function(\'xhprof_shutdown\');'));
	xhprof_enable(XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
}
