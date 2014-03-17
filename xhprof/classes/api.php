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
    
    public function getUris($likeUri, $filter = array()) {
        if (empty($filter['host_id'])) {
            $stmt = $this->db->prepare("
                SELECT
                    `uri`
                FROM
                    `request_uris`
                WHERE
                    `uri` LIKE ?
                ORDER BY
                    `uri`
                LIMIT 15;
            ");
            $stmt->execute(array('%'. $likeUri .'%'));
        }
        else
        {
            $stmt = $this->db->prepare("
                SELECT
                    `u`.`uri`
                FROM
                    `requests` `r`
                LEFT JOIN
                    `request_uris` `u` ON `r`.`request_uri_id` = `u`.`id`
                WHERE
                    `r`.`request_host_id` = ? AND
                    `u`.`uri` LIKE ?
                ORDER BY
                    `u`.`uri`
                LIMIT 15;
            ");
            $stmt->execute(array($filter['host_id'], '%'. $likeUri .'%'));
        }
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
