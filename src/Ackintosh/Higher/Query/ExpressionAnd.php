<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Interfaces\Expression as ExpressionInterface;
use Ackintosh\Higher\Traits\Expression;

class ExpressionAnd implements ExpressionInterface
{
    use Expression;
    protected $pre = 'AND';
}

