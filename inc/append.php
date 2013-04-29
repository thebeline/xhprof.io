<?php
	$where = (php_sapi_name() != 'cli') ? ("; A Virtual Host directive or .htaccess file associated with the address ".$_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI']) : "";
	error_log("Deprecated: xhprof.io - append.php - Please remove auto_append_file append.php, as this will break in the future. Suggested places to look: Your php.ini; A manual inclusion as a result of executing [".$_SERVER['DOCUMENT_ROOT'].'/'.$_SERVER['PHP_SELF'].']'.$where);
