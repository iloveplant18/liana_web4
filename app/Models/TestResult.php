<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $table = 'test_results';

    protected $fillable = [
        'date', 'name', 'answers', 'result', 'email'
    ];
}