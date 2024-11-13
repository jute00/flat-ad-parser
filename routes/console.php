<?php

use App\Services\KParser;
use App\Services\RParser;
use Illuminate\Support\Facades\Artisan;

Artisan::command('parse', function () {
    //(new KParser())->run();
    (new RParser())->run();
})->everyMinute();
