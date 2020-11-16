<?php
namespace App\Custom\Facades;

use Illuminate\Support\Facades\Facade;

class Holidays extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'holidays';
    }
}
