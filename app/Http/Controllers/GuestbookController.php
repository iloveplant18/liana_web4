<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Это для работы с файлами

class GuestbookController extends Controller
{
    private $file = 'messages.inc';

    // Показ формы и отзывов 
    public function index()
    {
        $messages = $this->getMessages(); 
        return view('guestbook', compact('messages'));
    }

    public function adminIndex() 
    {
        $messages = $this->getMessages();
        return view("admin.guestbook.index", compact("messages"));
    }

    // Сохранение нового отзыва
    public function store(Request $request)
    {
        $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $line = date('d.m.y') . ";" .
                $request->last_name . ";" .
                $request->first_name . ";" .
                $request->email . ";" .
                str_replace(["\n", "\r", ";"], ' ', $request->message) . "\n";

        Storage::append($this->file, $line);

        return redirect('/guestbook')->with('success', 'Отзыв успешно добавлен!');
    }

    // Показ формы загрузки файла
    public function createByFile()
    {
        return view('admin.guestbook.upload');
    }

    // Обработка загруженного файла
    public function storeByFile(Request $request)
    {
        $request->validate([
            'messages' => 'required|file|mimes:txt,text',
        ]);

        $contents = file_get_contents($request->file('messages')->getRealPath());
        Storage::put($this->file, $contents);

        return redirect('/guestbook')->with('success', 'Файл успешно загружен и обновлён!');
    }

    private function getMessages() {
        $messages = [];
        if (Storage::exists($this->file)) {
            $lines = array_reverse(explode("\n", trim(Storage::get($this->file))));
            foreach ($lines as $line) {
                $parts = explode(';', $line);
                if (count($parts) === 5) {
                    [$date, $last, $first, $email, $text] = $parts;
                    $messages[] = compact('date', 'last', 'first', 'email', 'text');
                }
            }
        }
        return $messages;
    }
}
