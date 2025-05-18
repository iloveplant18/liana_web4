<?php

namespace App\Http\Controllers\Admin;

use App\Models\Visitor;
use Illuminate\Http\Request;

class StatisticsController
{
    public function index(Request $request)
    {
        $visitors = Visitor::orderBy('visit_time', 'desc')
            ->paginate(10);

        return view('admin.statistics.index', compact('visitors'));
    }
}