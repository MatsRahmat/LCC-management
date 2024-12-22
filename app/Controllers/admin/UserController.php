<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\PaginationData;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected UserModel $userModel;
    protected $helpers = [];
    protected $builder;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $db = \Config\Database::connect();
        $this->builder = $db->table('users as u');
    }

    public function index()
    {
        $search = $this->request->getVar('search');
        $page = $this->request->getVar('page') ?? 1;

        $limit = 1;
        $offset = ($page - 1) * $limit;

        $builder = $this->builder;
        $builder->select('u.id, u.username, u.email, u.phone, u.nim, r.name role, ps.name prodi, u.created_by');
        $builder->join('roles as r', 'r.id = u.role_id');
        $builder->join('program_studies ps', 'u.study_id = ps.id', 'left');

        if ($search) {
            $builder->where('username', $search);
        }
        $query = $builder->orderBy('id', 'DESC')->get($limit, $offset);

        $paginationData = PaginationData::generate($builder, $limit, $page);

        $data = [
            'users'         => $query->getResultArray(),
            'pagination'    => $paginationData
        ];

        return view('pages/user/user_view', $data);
    }

    /**
     * Method untuk menampilkan halaman tambah
     */
    public function add()
    {
        return view('');
    }
}
