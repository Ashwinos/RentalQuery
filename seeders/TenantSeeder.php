<?php

namespace Database\Seeders;

use App\Models\Tenants;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantSeeder extends Seeder
{
    protected $userId;
    
   

    public function __construct($userId)
    {
        $this->userId = $userId;
        
        
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenantId = DB::table('tenants')->insertGetId([
            'owner_id' => $this->userId,
            'type' => fake()->randomElement(['saas-admin', 'business']),
            'name' => fake()->name(),
            'description' => fake()->text(200),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $user = DB::table('users')->where('id', $this->userId)->update([
            'tenant_id' => $tenantId
        
         
        
        ]);
        
        (new TaxprofileSeeder($tenantId, $this->userId))->run();
        (new CustomerSeeder($tenantId))->run();

        $taxProfileIds = DB::table('tax_profiles')->where('tenant_id', $tenantId)->pluck('id');

        foreach ($taxProfileIds as $taxProfileId) {
            $taxprofileratesSeeder = new TaxprofileratesSeeder($tenantId, $this->userId, $taxProfileId);
            $taxprofileratesSeeder->run();
        }
        (new InventoryItemCategorySeeder($tenantId))->run();

        $inventoryItemCategoriesIds = DB::table('inventory_item_categories')->where('tenant_id', $tenantId)->pluck('id');

        foreach ($inventoryItemCategoriesIds as $inventoryItemCategoriesId) {
            
            (new InventoryItemSeeder($tenantId, $this->userId, $taxProfileId, $inventoryItemCategoriesId))->run();
        }
        
        
    }
}
