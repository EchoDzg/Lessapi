<?php
namespace core\lib;

class ThrowableError extends \ErrorException
{
    public function __construct(\Throwable $e)
    {
        
        $this->setTrace($e->getTrace());
    }

    protected function setTrace($trace)
    {
        $traceReflector = new \ReflectionProperty('Exception', 'trace');
        $traceReflector->setAccessible(true);
        $traceReflector->setValue($this, $trace);
    }
}
