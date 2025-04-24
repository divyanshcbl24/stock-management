<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = [
            [
                'name' => 'Tech Solutions Inc.',
                'email' => 'info@techsolutions.com',
                'phone' => '+1234567890',
                'address' => '123 Tech Street, Silicon Valley',
            ],
            [
                'name' => 'Fashion Forward Ltd.',
                'email' => 'contact@fashionforward.com',
                'phone' => '+1987654321',
                'address' => '456 Style Avenue, Fashion District',
            ],
            [
                'name' => 'Fresh Foods Co.',
                'email' => 'sales@freshfoods.com',
                'phone' => '+1122334455',
                'address' => '789 Market Street, Food Court',
            ],
        ];

        foreach ($vendors as $vendor) {
            Vendor::create($vendor);
        }
    }
}
