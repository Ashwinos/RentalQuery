<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    protected $count;

    public function __construct($count = 1)
    {
       $this->count = $count; 
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < $this->count; $i++) {
            $userId = DB::table('users')->insertGetId([
                'tenant_id' => null,
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            (new TenantSeeder($userId))->run();
        }    
    }
}
