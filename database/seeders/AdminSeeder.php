<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'stewardingunj@gmail.com',
            'nim' => 'stewardingunj@gmail.com',
            'password' => Hash::make('Dosenpkkunj'),
            'role' => 'admin',
            'email_verified_at' => Carbon::now()->toDateTimeString()
        ]);
    }
}
