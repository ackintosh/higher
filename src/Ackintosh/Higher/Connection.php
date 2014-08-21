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
    }

    public function setUp()
    {
        $this->pdo = new \PDO(
            $this->makeDsn($this->params),
            $this->params['user'],
            $this->params['password']
        );

        $this->location = $this->params['host'] . '.' .$this->params['dbname'];

        return $this;
    }

    private function makeDsn()
    {
        $dsn = '';
        foreach ($this->params as $k => $v) {
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
