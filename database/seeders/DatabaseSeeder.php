<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Model::unguard();
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(StatusesTableSeedcer::class);
        $this->call(FollowersTableSeeder::class);

        Model::reguard();
    }
}
