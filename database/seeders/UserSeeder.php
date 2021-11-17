<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();
        $now = Carbon::now()->format('Y-m-d H:i:s');

        DB::table("users")->insert([
            "name" => $faker->name(),
            "email" => $faker->safeEmail,
            "password" => $faker->password,
            "created_at" => $now,
            "updated_at" => $now
        ]);
    }
}
