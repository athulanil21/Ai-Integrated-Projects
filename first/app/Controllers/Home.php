<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function view(): string
    {
        echo "This is the view method in Home controller.";
    }
}
