<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestResult;

class ExampleController extends Controller
{
    public function example()
    {
        // Способ 1: Создание через конструктор
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'answers' => json_encode(['answer1', 'answer2']),
            'result' => 'success',
            'date' => now()
        ];
        
        $testResult = new TestResult($data);
        $testResult->save();

        // Способ 2: Создание через присваивание свойств
        $testResult2 = new TestResult();
        $testResult2->name = 'Jane Doe';
        $testResult2->email = 'jane@example.com';
        $testResult2->answers = json_encode(['answer1', 'answer2']);
        $testResult2->result = 'success';
        $testResult2->date = now();
        $testResult2->save();

        return 'Записи успешно созданы!';
    }
} 