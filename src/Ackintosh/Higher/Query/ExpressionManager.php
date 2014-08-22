<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Query\ExpressionAnd;
use Ackintosh\Higher\Query\ExpressionOr;

class ExpressionManager
{
    private $exprs;

    public function __construct()
    {
        $this->exprs = [];
    }

    public function _($table, $params)
    {
        return $this->_and($table, $params);
    }

    public function _and($table, $params)
    {
        $this->exprs[] = new ExpressionAnd($table, $params);
    }

    public function _or($table, $params)
    {
        $this->exprs[] = new ExpressionOr($table, $params);
    }

    public function toString()
    {
        $strs = array_map(function ($expr) {
            return $expr->toString();
        }, $this->exprs);

        $ret = implode(' ', $strs);
        return $this->ltrim($ret);
    }

    public function getValues()
    {
        $vals = array_map(function ($expr) {
            return $expr->getValue();
        }, $this->exprs);

        return $vals;
    }

    public function ltrim($str)
    {
        $str = ltrim($str, 'AND');
        $str = ltrim($str, 'OR');
        return $str;
    }
}
