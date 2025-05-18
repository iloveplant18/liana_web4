<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\FormValidation;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $requets) {
        $validator = new FormValidation();
        $validator->setRule('name', 'isNotEmpty')
            ->setRule('age', 'isNotEmpty')
            ->setRule('age', 'isInteger')
            ->setRule('age', 'isGreater', 0)
            ->setRule('age', 'isLess', 150)
            ->setRule('message', 'isNotEmpty')
            ->setRule('gender', 'isNotEmpty');

        $validator->validate($requets->all());
        $errors = $validator->getErrors();

        if (!empty($errors)) {
            return redirect()->back()
                ->withErrors($errors)
                ->withInput();
        }

        // Process the form data (e.g., save to database, send email, etc.)
        return redirect()->back()->with('success', 'Данные успешно отправлены!');
    }
}
