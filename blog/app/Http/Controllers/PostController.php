<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //create var w nhot feha les posts lkol
        $posts=Post::orderBy('id','desc')->paginate(5);

        //return view w n3adiw maah lvar edhika
        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories =Category::all();
        $tags = Tag::all();

        return view('posts.create')->withCategories($categories)->withTags($tags);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate data
        $this->validate($request,array(

                'title' => 'required|max:255',
                'slug'=>'required|alpha_dash|max:255|min:5|unique:posts,slug',
                'category_id'=>'required|integer',
                'body' => 'required',)
        );
        // store in the db
        $post = new Post();
        $post->title=$request->title;
        $post->slug=$request->slug;
        $post->category_id=$request->category_id;
        $post->body=$request->body;

        $post->save();
        $post->tags()->sync($request->tags, false);

        Session::flash('success','The Blog post was successfully saved');
        //redirect to another page
        return redirect()->route('posts.show',$post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::find($id);
        //lwith bech thez men hn� lel view wala withPost
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=Post::find($id);
        $categories =Category::all();
        $cats=[];
        foreach($categories as $category){
            $cats[$category->id]=$category->name;
        }
        $tags = Tag::all();
        $tags2 = array();
        foreach ($tags as $tag) {
            $tags2[$tag->id] = $tag->name;
        }
        return view('posts.edit')->withPost($post)->withCategories($cats)->withTags($tags2);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post=Post::find($id);



        if ($request->input('slug')==$post->slug){
            $this->validate($request,array(
                'title' => 'required|max:255',
                'category_id'=>'required|integer',
                'body' => 'required',));}
        else{
            $this->validate($request,array(
                    'title' => 'required|max:255',
                    'slug'=>'required|alpha_dash|max:255|min:5|unique:posts,slug',
                    'category_id'=>'required|integer',
                    'body' => 'required',)
            );
        }

        $post=Post::find($id);
        $post->title=$request->input('title');
        $post->slug=$request->input('slug');
        $post->category_id=$request->input('category_id');
        $post->body=$request->input('body');
        $post->save();


        if (isset($request->tags)) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync(array());
        }
        Session::flash('success','The Blog post was successfully updated');
        return redirect()->route('posts.show',$post->id);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::find($id);
        $post->tags()->detach();

        $post->delete();
        Session::flash('success','The Blog post was successfully deleted');
        return redirect()->route('posts.index');
    }
}
