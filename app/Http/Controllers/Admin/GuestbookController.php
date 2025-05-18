<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestbookMessage;
use Illuminate\Http\Request;

class GuestbookController extends Controller
{
    public function uploadForm()
    {
        return view('admin.guestbook.upload');
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:inc|max:1024'
        ]);

        try {
            $file = $request->file('file');
            $content = file_get_contents($file->getPathname());
            $messages = explode("\n", $content);
            
            $count = 0;
            foreach ($messages as $message) {
                $message = trim($message);
                if (empty($message)) continue;

                $parts = explode('|', $message);
                if (count($parts) !== 2) continue;

                [$name, $text] = $parts;
                GuestbookMessage::create([
                    'name' => trim($name),
                    'message' => trim($text)
                ]);
                $count++;
            }

            return redirect()
                ->route('admin.guestbook')
                ->with('success', "Успешно загружено {$count} сообщений");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Ошибка при обработке файла: ' . $e->getMessage());
        }
    }
} 