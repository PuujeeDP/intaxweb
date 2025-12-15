<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'name' => 'Tech Corp',
                'slug' => 'tech-corp',
                'description' => 'Leading technology solutions provider',
                'website' => 'https://techcorp.example.com',
                'tags' => ['Technology', 'SaaS', 'Enterprise'],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'E-Shop Ltd',
                'slug' => 'e-shop-ltd',
                'description' => 'Online retail platform',
                'website' => 'https://eshop.example.com',
                'tags' => ['E-Commerce', 'Retail'],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Finance Plus',
                'slug' => 'finance-plus',
                'description' => 'Financial services company',
                'website' => 'https://financeplus.example.com',
                'tags' => ['Finance', 'Banking', 'Enterprise'],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Health Care Solutions',
                'slug' => 'health-care-solutions',
                'description' => 'Healthcare technology provider',
                'website' => 'https://healthcare.example.com',
                'tags' => ['Healthcare', 'Technology'],
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Edu Platform',
                'slug' => 'edu-platform',
                'description' => 'Online education platform',
                'website' => 'https://eduplatform.example.com',
                'tags' => ['Education', 'SaaS'],
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Food Delivery Co',
                'slug' => 'food-delivery-co',
                'description' => 'Food delivery service',
                'website' => 'https://fooddelivery.example.com',
                'tags' => ['Food', 'E-Commerce', 'Delivery'],
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }
    }
}
