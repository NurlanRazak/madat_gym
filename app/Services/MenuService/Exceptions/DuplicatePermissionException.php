<?php

namespace App\Services\MenuService\Exceptions;

use Exception;

class DuplicatePermissionException extends Exception
{

    protected $ability;
    protected $model;
    protected $names;

    public function __construct(string $ability, string $model, array $names)
    {
        $this->ability = $ability;
        $this->model = $model;
        $this->names = implode(', ', $names);
    }

    public function report()
    {
        abort(500, "There are duplicate permissions[{$this->names}] to {$this->ability} \"{$this->model}\" model");
    }

}
