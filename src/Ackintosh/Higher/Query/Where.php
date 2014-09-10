<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Query\Expression\ExpressionUnit;

class Where
{
    /**
     * @var array
     */
    private $expressions;

    public function __construct($args)
    {
        $this->expressions = [];

        foreach ($args as $arg) {
            if (is_string($arg)) {
                $this->expressions[] = $arg;
                continue;
            }

            $expr = new ExpressionUnit;
            call_user_func_array($arg, [$expr]);
            $this->expressions[] = $expr;
        }
    }

    public function toString()
    {
        if (count($this->expressions) === 0) {
            return '';
        }

        $str = ' WHERE ';

        foreach ($this->expressions as $expr) {
            if (is_string($expr)) {
                $str .= $expr;
                continue;
            }

            $str .= ' ( ' . $expr->toString() . ' ) ';
        }

        return $str;
    }

    public function getValues()
    {
        $values = [];
        foreach ($this->expressions as $expr) {
            if (is_string($expr)) {
                continue;
            }

            foreach ($expr->getValues() as $v) {
                $values[] = $v;
            }
        }

        return $values;
    }
}
