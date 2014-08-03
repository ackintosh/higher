<?php
namespace Ackintosh\Higher;

class Connection
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $location;

    public function __construct($params)
    {
        $this->params = $params;
        $this->setUp($params);
    }

    private function setUp($params)
    {
        $this->pdo = new \PDO(
            $this->makeDsn($params),
            $params['user'],
            $params['password']
        );

        $this->location = $params['host'] . '.' .$params['dbname'];
    }

    private function makeDsn($params)
    {
        $dsn = '';
        foreach ($params as $k => $v) {
            switch ($k) {
                case 'user':
                case 'password':
                    break;
                case 'type':
                    $dsn .= $v . ':';
                    break;
                default:
                    $dsn .= "{$k}={$v};";
                    break;
            }
        }

        return $dsn;
    }

    public function __call($name, $args)
    {
        return call_user_func_array([$this->pdo, $name], $args);
    }

    public function getLocation()
    {
        return $this->location;
    }
}
