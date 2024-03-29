<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Comment;


class AdminCommentsController extends Controller{

    private $rules = [
        'post_id' => 'required|numeric',
        'comment' => 'required|min:3|max:1000'
    ];

    public function index(){
        return view('admin.comments.index', [
            'comments' => Comment::latest()->paginate(10)
        ]);
    }
    
    public function create(){
        return view('admin.comments.create', [
            'posts' => Post::pluck('title', 'id')
        ]);
    }

    public function store(Request $request){
        $validated = $request->validate($this->rules);
        $validated['user_id'] = auth()->id();

        Comment::create($validated);
        return redirect()->route('admin.comments.create')->with('success', 'Comment has been added Successfully.');
    }
    
    public function edit(Comment $comment){
        return view('admin.comments.edit', [
            'posts' => Post::pluck('title', 'id'),
            'comment' => $comment
        ]);
    }

    public function update(Request $request, Comment $comment){
        $validated = $request->validate($this->rules);
        $comment->update($validated);
        return redirect()->route('admin.comments.edit', $comment)->with('success', 'Comment has been updated Successfully.');
    }
    
    public function destroy(Comment $comment){
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Comment has been deleted Successfully.');
    }
}
