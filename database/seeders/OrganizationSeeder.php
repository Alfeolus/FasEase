<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organization::firstOrCreate(
            [
                'slug' => 'fasease',
            ],
            [
                'name'  => 'FasEase',
                'slug' => 'fasease',
                'token' => Str::random(40),
                'image' => null,
            ]
        );
    }
}
