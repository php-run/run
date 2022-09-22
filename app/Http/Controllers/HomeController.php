<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;

class HomeController
{

    public function index(){

        $user = User::create([
            "name" => "new user",
            "email" => "new@gmail.com",
        ]);

        return new Response([
            "data" => $user,
            "msg" => "hello there from home controller",
            "status" => "success request",
        ]);
    }


    public function get(){

        return new Response([
            "msg" => "hello Get method",
            "status" => "success request",
        ]);
    }

}