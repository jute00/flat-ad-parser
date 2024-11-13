<?php

use App\Services\ParserService;
use Illuminate\Support\Facades\Artisan;

Artisan::command('parse', function () {
    (new ParserService())->run();
})->everyMinute();
