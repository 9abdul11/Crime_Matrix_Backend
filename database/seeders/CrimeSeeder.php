<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Crime;

class CrimeSeeder extends Seeder
{
    public function run()
    {
        // CrimeSeeder.php file                
        $csvFile = storage_path('app/crimes_dataset.csv');
        $csv = array_map('str_getcsv', file($csvFile));

        // Skip the header row (assuming it's the first row)
        array_shift($csv);

        foreach ($csv as $row) {
            // Check if the required keys exist in the $row array
            if (isset($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7])) {
                Crime::create([
                    'user_id' => $row[0],
                    'type' => $row[1],
                    'location' => $row[2],
                    'longitude' => $row[3],
                    'latitude' => $row[4],
                    'source' => $row[5],
                    'time' => $row[6],
                    'date' => $row[7],
                ]);
            } else {
                // Log or handle the case where the required keys are not present in $row
                // For example, you can log an error and continue or skip this row
                \Log::error('Missing keys in row: ' . json_encode($row));
            }
        }
    }
}