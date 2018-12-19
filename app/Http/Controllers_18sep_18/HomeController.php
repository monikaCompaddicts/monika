<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
//use App\Mail\SendMailable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function mail()
    {
       $data = ['name' => 'Krunal'];


        Mail::send('emails.name',$data, function ($message) {
            $message->to('monika@compaddicts.com');
            $message->subject('VMandi testing');
        });
       //Mail::to('monika@compaddicts.com')->send(new SendMailable($name));
       //Mail::to('monika@compaddicts.com')->send(new \App\Mail\SendMailable($user));
       
       echo 'Email was sent';exit;
    }
}
