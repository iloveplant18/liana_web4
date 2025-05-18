<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $postId)
    {
        $xmlString = $request->input('xml');
        $xml = simplexml_load_string($xmlString);
        $commentText = (string)$xml->text;

        Comment::create([
            'post_id' => $postId,
            'user_id' => session("user_id"),
            'comment' => $commentText
        ]);

        return response('<response><status>success</status><message>Комментарий добавлен</message></response>', 200)
            ->header('Content-Type', 'application/xml');
            
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
