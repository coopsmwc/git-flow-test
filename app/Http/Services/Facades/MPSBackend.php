<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class MPSBackend extends Facade {

    protected static function getFacadeAccessor() {

        return 'ApiService';
    }
}
