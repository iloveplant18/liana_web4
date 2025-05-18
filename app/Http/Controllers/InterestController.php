<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interest;

class InterestController extends Controller
{
    public function index()
    {
        // Получаем данные из константы INTERESTS
        $interests = Interest::INTERESTS;
        return view('interests', compact('interests'));
    }
}
