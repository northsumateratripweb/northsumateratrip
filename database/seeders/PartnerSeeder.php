<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Trocellen Sdn Bhd Malaysia',
                'logo' => 'trocellen.png',
                'website' => null,
                'description' => 'Corporate client from Malaysia',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Perundingan UEP Malaysia',
                'logo' => 'uep.png',
                'website' => null,
                'description' => 'Corporate client from Malaysia',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bank Mandiri',
                'logo' => 'mandiri.png',
                'website' => 'https://bankmandiri.co.id',
                'description' => 'Banking partner',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Telkom Indonesia',
                'logo' => 'telkom.png',
                'website' => 'https://telkom.co.id',
                'description' => 'Telecommunication partner',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Pertamina',
                'logo' => 'pertamina.png',
                'website' => 'https://pertamina.com',
                'description' => 'Energy partner',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Garuda Indonesia',
                'logo' => 'garuda.png',
                'website' => 'https://garuda-indonesia.com',
                'description' => 'Airline partner',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($partners as $partner) {
            Partner::updateOrCreate(
                ['name' => $partner['name']],
                $partner
            );
        }
    }
}
