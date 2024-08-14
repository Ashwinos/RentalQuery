<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxprofileratesSeeder extends Seeder
{   
    
    protected $tenantId;
    protected $userId;
    protected $taxprofileId;

    public function __construct($tenantId, $userId, $taxprofileId)
    {
        $this->tenantId = $tenantId;
        $this->userId = $userId;
        $this-> taxprofileId = $taxprofileId;
       

    }
    public function run(): void
    {
        for($i=0; $i<10; $i++){
            $TaxprofilerateId = DB::table('tax_profile_rates')->insertGetId([

                'tenant_id' => $this->tenantId,
                'creator_id' => $this->userId,
                'profile_id' => $this->taxprofileId,
                'description' => fake()->text(200),
                'percentage' => fake()->randomFloat(4, 0, 100),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                
            ]);
        }
    }
}
