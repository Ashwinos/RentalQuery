<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryItemSeeder extends Seeder
{
    protected $tenantId;
    protected $userId;
    protected $taxprofileId;
    protected $inventoryitemcategoriesId;

    public function __construct($tenantId, $userId, $taxprofileId, $inventoryitemcategoriesId)
    {
        $this->tenantId = $tenantId;
        $this->userId = $userId;
        $this->taxprofileId = $taxprofileId;
        $this->inventoryitemcategoriesId = $inventoryitemcategoriesId;
    }

    public function run(): void
    {

        $skuBase = [];

        for ($i = 0; $i < 100; $i++) {

            if ('pricing_method' === 'fixed_rate_per_order') {
                $pricingPeriod = null;
            } elseif ('pricing_method' === null) {
                $pricingPeriod =  null;
            } else {
                $pricingPeriod = fake()->randomElement(['hour', 'day', 'week', 'month']);
            }

            $name = fake()->name();
            $baseSku = strtoupper(str_replace(' ', '_', $name));

            if (isset($skuBase[$baseSku])) {
                $skuBase[$baseSku]++;
                $sku = "{$baseSku}_{$skuBase[$baseSku]}";
            } else {
                $skuBase[$baseSku] = 1;
                $sku = $baseSku;
            }


            $InventoryitemsId = DB::table('inventory_items')->insertGetId([

                'tenant_id' => $this->tenantId,
                'creator_id' => $this->userId,
                'category_id' => $this->inventoryitemcategoriesId,
                'tax_profile_id' => $this->taxprofileId,
                'type' => fake()->randomElement(['rental-product', 'sale-product', 'service', 'bundle']),
                'tracking_type' => fake()->randomElement(['none', 'bulk', 'serialized']),
                'sku' => $sku,
                'name' => fake()->name(),
                'description' => fake()->text(200),
                'is_shortage_allowed' => fake()->randomElement([0, 1]),
                'shortage_limit' => 'is_shortage_allowed' === 0 ? 0 : fake()->numberBetween(1, 10),
                'buffer_time_before_in_minutes' => fake()->randomElement([0, 60]),
                'buffer_time_after_in_minutes' => fake()->randomElement([0, 60]),
                'is_chargeable' => fake()->randomElement([0, 1]),
                'pricing_method' => 'is_chargeable' === 0 ? null : fake()->randomElement(['flat_rate_per_period', 'fixed_rate_per_order']),
                'pricing_period' => $pricingPeriod,
                'price' => fake()->randomFloat(4, 0, 10000),
                'is_taxable' => 'is_chargeable' === 0 ? 0 : 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ]);
        }
    }
}
