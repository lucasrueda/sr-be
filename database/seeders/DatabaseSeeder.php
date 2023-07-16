<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::unprepared(file_get_contents(__DIR__.'/../../storage/sql/dynamic_events_challenge_tournament.sql'));
    }
}
