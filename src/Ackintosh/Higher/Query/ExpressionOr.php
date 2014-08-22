<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Interfaces\Expression as ExpressionInterface;
use Ackintosh\Higher\Traits\Expression;

class ExpressionOr implements ExpressionInterface
{
    use Expression;
    protected $pre = 'OR';
}
