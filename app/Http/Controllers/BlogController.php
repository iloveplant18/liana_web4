<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Utils\FormValidation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(9);
        return view('blog.index', compact('posts'));
    }

    public function adminIndex()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.blog.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id); //Ищет по id и публикует
        return view('blog.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Пост успешно удален');
    }

    public function edit(Post $post)
    {
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($validated);

        return response("
        const message = 'Пост успешно обновлен!';
        completeResponse();
        ")->header('Content-Type', 'text/javascript');
    }        

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        Log::info('Starting post creation', [
            'has_file' => $request->hasFile('image'), //был ли прикреплён файл изображения
            'has_csv' => $request->hasFile('csv_file'), //проверка формата файла
            'all_data' => $request->all() //Возвращает все данные, которые были отправлены с формо
        ]);

        $validator = new FormValidation();
        
        // Если загружен CSV файл, обрабатываем его
        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            
            // Проверяем расширение файла
            if ($file->getClientOriginalExtension() !== 'csv') {
                return back()->with('error', 'Пожалуйста, загрузите CSV файл')->withInput();
            }

            try {
                $handle = fopen($file->getPathname(), "r");
                if ($handle === FALSE) {
                    throw new \Exception("Не удалось открыть CSV файл");
                }

                // Пропускаем заголовок используется для пропуска первой строки CSV-файла, 
                // в которой, как правило, находятся заголовки столбцов (например: title,text,image,created_at), а не сами данные постов.
                fgetcsv($handle);
                
                $createdCount = 0;
                $errors = [];

                while (($data = fgetcsv($handle)) !== FALSE) {
                    if (count($data) < 3) {
                        $errors[] = "Строка не содержит всех необходимых данных";
                        continue;
                    }

                    $post = new Post();
                    $post->title = $data[0];
                    $post->content = $data[1];
                    $post->created_at = $data[2] ?: now();
                    
                    try {
                        $post->save();
                        $createdCount++;
                    } catch (\Exception $e) {
                        $errors[] = "Ошибка при сохранении поста: " . $e->getMessage();
                    }
                }

                fclose($handle);

                $message = "Успешно создано постов: $createdCount";
                if (!empty($errors)) {
                    $message .= ". Ошибок: " . count($errors);
                    Log::error('CSV import errors', ['errors' => $errors]);
                }

                return redirect()->route("admin.blog.index")->with('success', $message);
            } catch (\Exception $e) {
                Log::error('CSV import failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->with('error', 'Ошибка при обработке CSV файла: ' . $e->getMessage())->withInput();
            }
        }

        // Если загружено изображение, обрабатываем его
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            Log::info('File information', [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'error' => $file->getError()
            ]);
            $validator->setRule('image', 'isImage', $file);
        }

        // Добавляем базовые правила валидации
        $validator->setRule('title', 'isNotEmpty')
                 ->setRule('content', 'isNotEmpty');

        $validator->validate($request->all());

        if (!empty($validator->getErrors())) {
            Log::error('Validation errors', [
                'errors' => $validator->getErrors()
            ]);
            return back()->withErrors($validator->getErrors())->withInput();
        }

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                
                // Проверяем, что файл действительно был загружен
                if (!$file->isValid()) {
                    Log::error('File upload failed - file is not valid', [
                        'original_name' => $file->getClientOriginalName(),
                        'error' => $file->getError()
                    ]);
                    return back()->with('error', 'Ошибка при загрузке изображения')->withInput();
                }

                // Создаем директорию, если она не существует
                $path = public_path('images');
                if (!file_exists($path)) {
                    Log::info('Creating images directory', ['path' => $path]);
                    if (!mkdir($path, 0777, true)) {
                        Log::error('Failed to create images directory', ['path' => $path]);
                        return back()->with('error', 'Ошибка при создании директории для изображений')->withInput();
                    }
                }

                $filename = time() . '_' . $file->getClientOriginalName();
                
                Log::info('Attempting to move file', [
                    'from' => $file->getPathname(),
                    'to' => $path . '/' . $filename
                ]);

                // Сохраняем файл в public/images
                if (!$file->move($path, $filename)) {
                    Log::error('Failed to move file', [
                        'from' => $file->getPathname(),
                        'to' => $path . '/' . $filename
                    ]);
                    return back()->with('error', 'Ошибка при сохранении изображения')->withInput();
                }
                
                // Проверяем, что файл действительно был перемещен
                if (!file_exists($path . '/' . $filename)) {
                    Log::error('File was not moved to destination', [
                        'path' => $path,
                        'filename' => $filename
                    ]);
                    return back()->with('error', 'Ошибка при сохранении изображения')->withInput();
                }
                
                // Сохраняем относительный путь к файлу
                $post->image = '/images/' . $filename;
                
                Log::info('File uploaded successfully', [
                    'filename' => $filename,
                    'path' => $post->image,
                    'full_path' => $path . '/' . $filename
                ]);
            } catch (\Exception $e) {
                Log::error('File upload failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->with('error', 'Ошибка при загрузке изображения: ' . $e->getMessage())->withInput();
            }
        }

        try {
            $post->save();
            Log::info('Post created successfully', [
                'post_id' => $post->id,
                'has_image' => !empty($post->image)
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to save post', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Ошибка при сохранении поста')->withInput();
        }

        return redirect()->route("admin.blog.index")->with('success', 'Пост успешно создан!');
    }

} 