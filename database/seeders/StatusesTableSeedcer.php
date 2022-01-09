<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeedcer extends Seeder
{
    public function run()
    {
        Status::factory()->count(100)->create();
    }
}
