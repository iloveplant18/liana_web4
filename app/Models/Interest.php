<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    public const INTERESTS = [
        [
            'category' => 'Куклы',
            'title' => 'Монстер Хай',
            'description' => 'Я увлекаюсь куклами Монстер Хай. Это коллекционные куклы с уникальными историями и ярким стилем.',
        ],
        [
            'category' => 'Животные',
            'title' => 'Мои коты',
            'description' => 'У меня три кота: Нюся, Мира и Славик. Они каждый день наполняют дом уютом и радостью.',
        ],
        [
            'category' => 'Животные',
            'title' => 'Моя собака Бим',
            'description' => 'Бим — моя верная собака, которая всегда готова к прогулкам и приключениям.',
        ],
    ];
}
