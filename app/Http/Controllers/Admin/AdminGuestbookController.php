<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guestbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGuestbookController extends Controller
{
    public function index()
    {
        $messages = Guestbook::latest()->paginate(10);
        return view('admin.guestbook.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Guestbook::create($validated);

        return redirect()->route('admin.guestbook')
            ->with('success', 'Сообщение успешно добавлено');
    }

    public function uploadForm()
    {
        return view('admin.guestbook.upload');
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:txt|max:1024'
        ]);

        $file = $request->file('file');
        $content = file_get_contents($file->getRealPath());
        $messages = explode("\n", $content);

        foreach ($messages as $message) {
            if (trim($message) !== '') {
                Guestbook::create([
                    'name' => 'Импортированный пользователь',
                    'message' => trim($message)
                ]);
            }
        }

        return redirect()->route('admin.guestbook')
            ->with('success', 'Сообщения успешно импортированы');
    }
} 