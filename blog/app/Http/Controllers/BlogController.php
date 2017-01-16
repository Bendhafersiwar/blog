<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function getSingle($slug){
        //fetch in the db based on slug
             $post=Post::where('slug','=',$slug)->first();
        //return the view and pass in the post object
        return view('blog.single')->withPost($post);

    }
    public function getIndex(){
        $posts=Post::paginate(10);

        return view('blog.index')->withPosts($posts);


    }
}
