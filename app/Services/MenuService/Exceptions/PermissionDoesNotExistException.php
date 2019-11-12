<?php

namespace App\Services\MenuService\Exceptions;

use Exception;

class PermissionDoesNotExistException extends Exception
{

    protected $ability;
    protected $model;

    public function __construct(string $ability, string $model)
    {
        $this->ability = $ability;
        $this->model = $model;
    }

    public function report()
    {
        abort(500, "Permission to {$this->ability} \"{$this->model}\" model does't exist!");
    }

}
