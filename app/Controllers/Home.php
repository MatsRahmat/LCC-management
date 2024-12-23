<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function add(){}
    public function insert(){}
    public function edit(){}
    public function update(){}
    public function delete(){}
}
