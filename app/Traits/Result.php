<?php

namespace App\Traits;

trait Result
{
    protected string $result;

    function getResult(): string
    {
        return $this->result;
    }
}
