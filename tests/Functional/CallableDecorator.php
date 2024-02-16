<?php

namespace Tests\Functional;

class CallableDecorator
{

    public $calledTimes;
    /**
     * @var callable $callable
     */
    private $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
        $this->calledTimes = 0;
    }

    public function __invoke()
    {
        $this->calledTimes++;
        return call_user_func($this->callable);
    }
}