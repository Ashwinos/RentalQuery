<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
        protected $tenantId;

        public function __construct($tenantId)
        {
            $this->tenantId = $tenantId;
        }

    public function run(): void
    {
        for($i = 0; $i < 101; $i++) {
        $CustomerId = DB::table('customers')->insertGetId([
            'tenant_id' => $this->tenantId,
            'name' => fake()->name(),
            'type' => fake()->randomElement(['individual', 'organization', 'company']), 
            'notes' => fake()->text(200),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
      
    }
}
