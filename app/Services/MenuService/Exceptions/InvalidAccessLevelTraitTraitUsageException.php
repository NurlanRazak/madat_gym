<?php

namespace App\Services\MenuService\Exceptions;

use Exception;

class InvalidAccessLevelTraitTraitUsageException extends Exception
{

    protected $class;

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function report()
    {
        abort(500, "Invalid AccessLevelsTrait usage in {$this->class} class!");
    }

}
