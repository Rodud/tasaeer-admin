<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PricingLaneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $lanes = config('pricing.lanes');

        if (!is_array($lanes) || empty($lanes)) {
            throw new RuntimeException(
                'No pricing lanes were found in the pricing configuration.'
            );
        }

      
        if (DB::table('pricing_lanes')->exists()) {
            $this->command?->warn(
                'pricing_lanes already contains data. No changes were made.'
            );

            return;
        }

        $now = now();

        $rows = [];

        foreach ($lanes as $lane) {
        
            if (
                !isset($lane['o']) ||
                !isset($lane['d']) ||
                !isset($lane['km']) ||
                !isset($lane['price'])
            ) {
                $this->command?->warn(
                    'Skipped an invalid pricing lane because required fields are missing.'
                );

                continue;
            }

            $rows[] = [
                'origin' => $lane['o'],
                'destination' => $lane['d'],
                'distance_km' => $lane['km'],
                'price' => $lane['price'],
                'is_firm' => $lane['firm'] ?? false,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (empty($rows)) {
            throw new RuntimeException(
                'No valid pricing lanes were found.'
            );
        }

     
        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('pricing_lanes')->insert($chunk);
        }

        $this->command?->info(
            count($rows) . ' pricing lanes imported successfully.'
        );
    }
}