<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function deletePost(Post $post) {
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }
        
        $post->delete();
        return redirect('/');

    }
    public function editPost(Post $post, Request $request) {
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        $requestedInfo = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $requestedInfo['title'] = strip_tags($requestedInfo['title']);
        $requestedInfo['body'] = strip_tags($requestedInfo['body']);

        $post->update($requestedInfo);
        return redirect('/');
    }
    public function editPostScreen(Post $post){
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        return view('edit-post', ['post' => $post]);
    }
    public function createPost(Request $request) {
        $requestedInfo = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $requestedInfo['title'] = strip_tags($requestedInfo['title']);
        $requestedInfo['body'] = strip_tags($requestedInfo['body']);

        $requestedInfo['user_id'] = auth()->id();
        Post::create($requestedInfo);
        return redirect('/');
    }

}
