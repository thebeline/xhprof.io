<?php
namespace ay\xhprof;

use PDO;

class api
{
    /**
     * @var \PDO
     */
    private $db;
    
    public function __construct(PDO $db)
    {
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql') {
            $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);
        }

        $this->db	= $db;
    }
    
    public function getHosts($likeHost) {
        $stmt = $this->db->prepare("
            SELECT
                `host`
            FROM
                `request_hosts`
            WHERE
                `host` LIKE ?
            ORDER BY
                `host`
            LIMIT 15;
        ");
        $stmt->execute(array('%'. $likeHost .'%'));
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
