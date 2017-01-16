<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    public function getIndex(){

          $posts=Post::orderBy('created_at','desc')->limit(4)->get();


        return view('pages/welcome')->withPosts($posts);
    }
    public function getAbout(){
        //non accessible
        $first='Alex';
        //non accessible
        $last='Curtes';
        $full=$first." ".$last;
        $email= "siwar@gmail.com";
        $data=[];
        $data['email']=$email;
        $data['fullname']=$full;
        //accessible khaterha mchet maa lwith
        //return view('pages/about')->with("fullname",$full);
        //return view('pages/about')->withFullname($full)->withEmail($email);
        return view('pages/about')->withData($data);

    }
    public function getContact(){
        return view('pages/contact');
    }
    public function postContact(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'min:3',
            'message' => 'min:10']);
        $data = array(
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message
        );
        Mail::send('emails.contact', $data, function($message) use ($data){
            $message->from($data['email']);
            $message->to('hello@siwarbendhafer.io');
            $message->subject($data['subject']);
        });
        Session::flash('success', 'Your Email was Sent!');
        return redirect('/');
    }


}
