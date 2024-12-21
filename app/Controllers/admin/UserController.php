<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index()
    {
        //
        return view('pages/user/user_view');
    }

    /**
     * Method untuk menampilkan halaman
     */
    public function add(){
        return view('');
    }
}
