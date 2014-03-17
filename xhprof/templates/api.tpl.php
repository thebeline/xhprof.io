<?php

namespace ay\xhprof;

if(empty($_GET['xhprof']['query']['target'])) {
    throw new \Exception('Missing required parameters.');
}

$xhprof_api_obj	= new api($config['pdo']);

switch ($_GET['xhprof']['query']['target']) {
    case 'hosts': {
        header('Content-Type: application/json');
        
        if(!\ay\error_present()) {
            $hosts	= $xhprof_api_obj->getHosts($_GET['term']);
            
            echo json_encode($hosts);
        }
        
        break;
    }
    case 'uris': {
        header('Content-Type: application/json');
        
        $filter = array('host_id' => $_GET['xhprof']['query']['host_id']);
        
        if(!\ay\error_present()) {
            $hosts	= $xhprof_api_obj->getUris($_GET['term'], $filter);
            
            echo json_encode($hosts);
        }
        
        break;
    }
    default : throw new \Exception('Invalid target.');
}

