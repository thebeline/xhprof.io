<?php

class DataPersistancePerfEvent extends Athletic\AthleticEvent
{
    /**
     * @var array
     */
    private $testProfile;

    /**
     * @var PDO
     */
    private $pdo;

    public function classSetUp()
    {
        $this->testProfile = unserialize(file_get_contents(dirname(__FILE__) .'/test.profile'));
        $this->pdo = new PDO('mysql:dbname=xhprof;host=127.0.0.1', 'root', '');
    }

    /**
     * @iterations 1000
     */
    public function persistProfile()
    {
        // XXX fake server env in a cleaner way
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '/index.htm';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $xhprof_data_obj = new \ay\xhprof\data($this->pdo);
        $xhprof_data_obj->save($this->testProfile);
    }
}
