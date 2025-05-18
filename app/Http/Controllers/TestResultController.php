<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Illuminate\Http\Request;

class TestResultController extends Controller
{
    public function index()
    {
        $results = TestResult::orderBy('created_at', 'desc')->get();
        return view('test-results', compact('results'));
    }
} 