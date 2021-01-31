<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getUser()
    {
        return User::factory([
            'email' => 'dimakornev13@yandex.ru',
            'name' => 'dimakornev13',
            'password' => bcrypt('Nac578')
        ])->make();
    }
}
