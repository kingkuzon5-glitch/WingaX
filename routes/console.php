<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('db:ensure-schema', function () {
    $schema = config('database.connections.pgsql.search_path');

    if (config('database.default') !== 'pgsql' || $schema === 'public') {
        return;
    }

    DB::statement('CREATE SCHEMA IF NOT EXISTS "'.$schema.'"');
    $this->info("Ensured schema \"{$schema}\" exists.");
})->purpose('Create the configured Postgres schema if it does not already exist');
