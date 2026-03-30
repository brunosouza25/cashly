<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| Aqui dizemos ao Pest que todos os testes na pasta "Feature"
| devem estender a classe TestCase do Laravel e usar o RefreshDatabase.
|
*/

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| Você pode adicionar métodos customizados aqui se quiser.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});
