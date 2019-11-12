<?php

namespace App\Services\MenuService\Exceptions;

use Exception;

class RoleDoesNotExistException extends Exception
{

    protected $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function report()
    {
        abort(500, "Role {$this->key} doesn't exist!");
    }

}
