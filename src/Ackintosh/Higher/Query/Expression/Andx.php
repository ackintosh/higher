<?php
namespace Ackintosh\Higher\Query\Expression;
use Ackintosh\Higher\Interfaces\Expression as ExpressionInterface;
use Ackintosh\Higher\Traits\Expression;

class Andx implements ExpressionInterface
{
    use Expression;
    protected $pre = 'AND';
}

