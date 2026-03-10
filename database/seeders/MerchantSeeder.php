<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        $merchants = [
            ['name' => 'SAJJ Pizza and Shawarma',                          'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Copper Fusion',                                     'commission_type' => 'category_based_fixed', 'commission_rate' => 0, 'commission_food_amount' => 25, 'commission_drinks_amount' => 15],
            ['name' => 'RoadTrip Kitchen and Cafe by Rikitos',              'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Lugaw Republic',                                    'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Garahe - Authentic Pancit Cabagan & Batil Patong',  'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Sinner or Saint Cafe Main',                        'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Master Tea',                                        'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Lechon House Baguio',                               'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Mang Ed Bakareta House',                            'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Area - Arts and Eats',                              'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Le Bloom Mobile Café',                              'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Gray Area',                                         'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Mochiii',                                           'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => "Project'Star Harbor Café",                          'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Green Smoothie',                                    'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Ramen Naijiro',                                     'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Patata Pungko-Pungko',                              'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Starway Restaurant',                                'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => "Raff's Fried Chicken - Military Cut-off",           'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Malapit Restaurant',                                'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Rose Café',                                         'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Sushikami',                                         'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => "Gov. Pack Branch - Pet's Bulalohan",                'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Smoke Bros',                                        'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Mangosssip',                                        'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Feli Ramen and Food House',                         'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'NOODS',                                             'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Hiraya Café',                                       'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Soledad',                                           'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Paylite Corner',                                    'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'J & B Pigar-Pigar',                                'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Turks',                                             'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Ranee House of Curry',                              'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'CraftBurger by BrrrGrrr - Camp 7',                 'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Wok Your Way',                                      'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Himalayan Nepalese Cuisine',                        'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => "Lim's Tapa House",                                  'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => "Marciana's Lechon Manok and Food House",            'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Red Rustikz',                                       'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'H100 Ecolodge Restaurant',                         'commission_type' => 'percentage_based', 'commission_rate' => 15],
            ['name' => 'Chowtime Slu Gate Branch',                         'commission_type' => 'percentage_based', 'commission_rate' => 10],
            ['name' => 'Chowtime Lower Bonifacio Branch',                   'commission_type' => 'percentage_based', 'commission_rate' => 10],
        ];

        foreach ($merchants as $data) {
            Merchant::firstOrCreate(
                ['name' => $data['name']],
                array_merge([
                    'type'                    => 'partner',
                    'status'                  => 'active',
                    'commission_rate'         => 0,
                    'commission_type'         => 'percentage_based',
                    'commission_food_amount'  => null,
                    'commission_drinks_amount'=> null,
                ], $data)
            );
        }

        // ── NON-PARTNERS ──────────────────────────────────────────────────────────
        $nonPartners = [
            // Simple percentage-based
            ['name' => 'Grumpy Joe',                                          'commission_type' => 'percentage_based',  'commission_rate' => 17],
            ['name' => 'Rose Bowl Steakhouse and Restaurant Baguio',          'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Teahouse Restaurant and Bakeshop',                    'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Jacks Baguio Restaurant',                             'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Sr. Pedro',                                           'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Andoks',                                              'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Plato Wraps',                                         'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Greenwich',                                           'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Sizzling Plate Steakhouse',                           'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Jollibee – Legarda',                                  'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => "Dunkin' Donuts",                                      'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => "Cathy's Fastfood",                                    'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => "Mikko's Kitchenette",                                 'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Mang Inasal – Legarda',                               'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ["name" => "McDonald's Insular",                                  'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Mister Donut',                                        'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ["name" => "O' Mai Khan Restaurant",                              'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Balajadia Kitchenette',                               'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ["name" => "50's Diner Baguio",                                   'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'E-Pagatang idyay Drugstore',                          'commission_type' => 'percentage_based',  'commission_rate' => 20],
            ['name' => 'E-Pagatang idyay Tiong San',                          'commission_type' => 'percentage_based',  'commission_rate' => 20],
            ['name' => 'E-Pagatang idyay 711',                                'commission_type' => 'percentage_based',  'commission_rate' => 20],
            ['name' => 'Kubong Sawali',                                       'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Minute Burger',                                       'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Baliwag Lechon Manok at Liempo',                     'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Solibao Upper Session',                               'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Sabrozo Grillers',                                    'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Senor Sabrozo',                                       'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Enzo Pizza And Pasta',                                'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Central Park',                                        'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ["name" => "Jhoevis Rustic Cuts and Soups Eatery",                'commission_type' => 'percentage_based',  'commission_rate' => 10],
            ['name' => 'Antonio Pizza',                                       'commission_type' => 'percentage_based',  'commission_rate' => 12],
            ["name" => "Bruno's Diner",                                       'commission_type' => 'percentage_based',  'commission_rate' => 15],
            ['name' => 'Palaganas Bakery',                                    'commission_type' => 'percentage_based',  'commission_rate' => 15],
            ['name' => 'Savory Vibes',                                        'commission_type' => 'percentage_based',  'commission_rate' => 15],
            ["name" => "Lloyd's Kitchen",                                     'commission_type' => 'percentage_based',  'commission_rate' => 15],
            ['name' => 'Biryani Express',                                     'commission_type' => 'percentage_based',  'commission_rate' => 12],
            ['name' => 'Casa Pizzeria',                                       'commission_type' => 'percentage_based',  'commission_rate' => 15],

            // Fixed per item (flat pesos per item)
            ['name' => 'Sab-atan Restaurant',                                 'commission_type' => 'fixed_per_item',    'commission_rate' => 20],
            ['name' => 'Siomai House Baguio',                                 'commission_type' => 'fixed_per_item',    'commission_rate' => 10],
            ["name" => "Tita Lea's Food Specialties City",                    'commission_type' => 'fixed_per_item',    'commission_rate' => 20],
            ['name' => 'Pandesalan 24/7',                                     'commission_type' => 'fixed_per_item',    'commission_rate' =>  2],
            ["name" => "Zio's Pizzeria",                                      'commission_type' => 'fixed_per_item',    'commission_rate' => 20],
            ["name" => "Town's Pizza",                                        'commission_type' => 'fixed_per_item',    'commission_rate' => 20],
            ['name' => 'St. Martin',                                          'commission_type' => 'fixed_per_item',    'commission_rate' => 20],

            // Small / big order tiers
            ['name' => 'Superhero Verse',
                'commission_type'         => 'mixed',
                'commission_rate'         => 0,
                'commission_small_amount' => 15,
                'commission_big_amount'   => 25,
                'commission_items'        => json_encode([
                    ['label' => 'Small orders', 'amount' => 15],
                    ['label' => 'Big orders',   'amount' => 25],
                ]),
            ],

            // Two fixed tiers (100 / 150)
            ['name' => 'Flower City',
                'commission_type'         => 'mixed',
                'commission_rate'         => 0,
                'commission_small_amount' => 100,
                'commission_big_amount'   => 150,
                'commission_items'        => json_encode([
                    ['label' => 'Tier 1', 'amount' => 100],
                    ['label' => 'Tier 2', 'amount' => 150],
                ]),
            ],

            // Mixed: per-piece + percentage for boxes
            ['name' => 'Victoria Bakery - Magsaysay Branch',
                'commission_type'              => 'mixed',
                'commission_rate'              => 0,
                'commission_mixed_amount'      => 10,
                'commission_mixed_percentage'  => 10,
                'commission_items'             => json_encode([
                    ['label' => 'Per piece',  'amount' => 10],
                    ['label' => 'Boxes',      'percentage' => 10],
                ]),
            ],

            // All items 10 pesos, add-ons 5 pesos
            ['name' => 'Zentea Baguio PVM',
                'commission_type'  => 'fixed_per_item',
                'commission_rate'  => 10,
                'commission_items' => json_encode([
                    ['label' => 'All items', 'amount' => 10],
                    ['label' => 'Add-ons',   'amount' =>  5],
                ]),
            ],

            // Complex item-based: Ali's House of Shawarma
            ["name" => "Ali's House of Shawarma",
                'commission_type'  => 'fixed_per_item',
                'commission_rate'  => 20,
                'commission_items' => json_encode([
                    ['label' => 'Mains',                    'amount' => 20],
                    ['label' => 'Add-ons',                  'amount' => 10],
                    ['label' => 'Take-out – Shawarma',      'amount' => 20],
                    ['label' => 'Take-out – Samosa',        'amount' => 10],
                    ['label' => 'Take-out – Pita Bread',    'amount' =>  5],
                ]),
            ],

            // No commission / no price changes
            ['name' => 'Sr. TalangCrab',   'commission_type' => 'percentage_based', 'commission_rate' => 0],
            ["name" => "Susan's Veranda",  'commission_type' => 'percentage_based', 'commission_rate' => 0,
                'commission_items' => json_encode([['label' => 'No changes on prices', 'amount' => 0]])],

            // Two-tier fixed per category of order
            ['name' => 'The Original Good Taste Restaurant',
                'commission_type'  => 'fixed_per_item',
                'commission_rate'  => 15,
                'commission_items' => json_encode([
                    ['label' => 'Rice toppings, mami, dimsum, dessert, cold beverage, soup (good for 3)', 'amount' => 15],
                    ['label' => 'All family style pancit (good for 6), soup good for 6, all lomi categories of pancit', 'amount' => 28],
                ]),
            ],
        ];

        foreach ($nonPartners as $data) {
            // Remove accidental duplicate keys (Zentea workaround above)
            Merchant::firstOrCreate(
                ['name' => $data['name']],
                array_merge([
                    'type'                       => 'non-partner',
                    'status'                     => 'active',
                    'commission_rate'            => 0,
                    'commission_type'            => 'percentage_based',
                    'commission_food_amount'     => null,
                    'commission_drinks_amount'   => null,
                    'commission_small_amount'    => null,
                    'commission_big_amount'      => null,
                    'commission_mixed_percentage'=> null,
                    'commission_mixed_amount'    => null,
                    'commission_items'           => null,
                ], $data)
            );
        }
    }
}
