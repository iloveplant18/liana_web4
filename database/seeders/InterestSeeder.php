<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Interest;

class InterestSeeder extends Seeder
{
    public function run(): void
    {
        Interest::create([
            'title' => 'Коты',
            'description' => 'Коты — это невероятно грациозные и умные животные. Они приносят радость и уют в дом.',
        ]);

        Interest::create([
            'title' => 'Собаки',
            'description' => 'Собаки — это верные друзья человека. Они всегда готовы поддержать и защитить.',
        ]);

        Interest::create([
            'title' => 'Куклы',
            'description' => 'Куклы — это не только игрушки, но и произведения искусства, которые могут быть коллекционными.',
        ]);
    }
}