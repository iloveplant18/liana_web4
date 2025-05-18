<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TestResult;
use Carbon\Carbon;
use App\Utils\ResultVerification;

class TestController extends Controller
{
    public function index()
    {
        return view('test'); 
    }

    public function store(Request $request)
    {
        $validator = new ResultVerification(); // Заменяем валидацию Ларавель на собственную
        $validator->validate($request);
        $errors = $validator->getErrors(); // Массив ошибок

        $result = empty($errors) ? 'success' : 'error';
               
        $answers = [
            'favorite_color' => $request->favorite_color,
            'animal' => $request->animal,
            'hobbies' => $request->input('hobbies')
        ];

        $testResult = new TestResult([ // Создаем новую запись в моделе базы данных
            'date' => Carbon::now()->format('Y-m-d'),
            'name' => $request->name,
            'answers' => json_encode($answers), // Store as JSON string
            'result' => $result,
            'email' => $request->email
        ]);
        $testResult->save(); //Сохраняем эту новую запись

        return redirect('/test-results'); //Автоматически переходим на страницу с результатами
    }

    public function testResults()
    {
        $results = TestResult::all(); //Выводим все строки таблицы
        return view('test-results', compact('results'));
    }
}
