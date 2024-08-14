<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxprofileSeeder extends Seeder
{
    protected $tenantId;
    protected $userId;

    public function __construct($tenantId, $userId)
    {
        $this->tenantId = $tenantId;
        $this->userId = $userId;
    }
    
    public function run(): void
    {

        for($i=0; $i<10; $i++){
            
            $TaxprofileId = DB::table('tax_profiles')->insertGetId([

                'tenant_id' => $this->tenantId,
                'creator_id' => $this->userId,
                'name' => fake()->name(),
                'is_default' => fake()->randomElement([1, 0]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
    
            ]);

        }
        
        
    }
}
