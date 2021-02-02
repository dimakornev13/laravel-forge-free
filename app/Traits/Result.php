<?php

namespace App\Traits;

trait Result
{
    protected string $result;


    /**
     * @return string
     */
    function getResult(): string
    {
        return $this->result;
    }
}
