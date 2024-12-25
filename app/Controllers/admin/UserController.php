<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Enums\RoleEnum;
use App\Enums\StateEnum;
use App\Helpers\PaginationData;
use App\Models\ProgramStudyModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;
use DateException;
use Exception;

class UserController extends BaseController
{
    protected UserModel $userModel;
    protected $helpers = [];
    protected $builder;
    protected $pages = ['title' => 'User', 'path' => ['Admin', 'User'], 'page_path' => 'a/admin/users'];

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

        $limit = 10;
        $offset = ($page - 1) * $limit;

        $builder = $this->builder;
        $builder->select('u.id, u.username, u.email, u.phone, u.nim, r.name role, ps.name prodi, u.created_by');
        $builder->where('u.deleted_at IS NULL');
        $builder->join('roles as r', 'r.id = u.role_id', 'left');
        $builder->join('program_studies ps', 'u.study_id = ps.id', 'left');

        if ($search) {
            $builder->where('username', $search);
        }
        $query = $builder->orderBy('id', 'DESC')->get($limit, $offset);

        $paginationData = PaginationData::generate($builder, $limit, $page);

        $data = [
            'page'          => $this->pages,
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
        $roleModel = new RoleModel();
        $prodiModel = new ProgramStudyModel();
        $roles = $roleModel->whereNotIn('id', [RoleEnum::SUPER_ADMIN])->findAll();
        $data = [
            'page'      => $this->pages,
            'roles'     => $roles,
            'prodies'   => $prodiModel->findAll()
        ];
        return view('pages/user/add_user_view', $data);
    }

    public function insert()
    {
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $db->transBegin();
        try {
            $role = $this->request->getPost('role');
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $phone = $this->request->getPost('phone');
            $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            $validationRule = [
                'username'  => 'required|max_length[200]',
                'email'     => 'required|valid_email',
                'phone'     => 'required|max_length[13]|min_length[11]',
                'password'  => 'required|max_length[200]|min_length[8]',
            ];

            $dataToInsert = [
                'username'  => $username,
                'email'     => $email,
                'phone'     => $phone,
                'password'  => $password,
                'role_id'      => (int) $role
            ];
            if ($role == "4") {
                $validationRule['nim']          = 'required|max_length[12]|min_length[12]';
                $validationRule['birth_date']   = 'required';
                $validationRule['prodi_id']        = 'required';

                $dataToInsert['nim']        = $this->request->getPost('nim');
                $dataToInsert['birth_date'] = $this->request->getPost('birth_date');
                $dataToInsert['study_id']   = (int) $this->request->getPost('prodi');
            }

            if (! $this->validate($validationRule)) {
                return redirect()->back()->withInput()->with(StateEnum::ERRORS, $this->validator->getErrors());
            }
            $this->userModel->insert($dataToInsert);
            $db->transCommit();
            return redirect()->to(base_url($this->pages['page_path']))->with(StateEnum::SUCCESS, 'Berhasil menambah user');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERRORS, $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $userUpdate = $this->userModel->select('id, username, email, phone, birth_date, nim, role_id, study_id, created_by')->find($id);
            $rolesModel = new RoleModel();
            $prodiModel = new ProgramStudyModel();
            $roles = $rolesModel->whereNotIn('id', [RoleEnum::SUPER_ADMIN])->findAll();
            $prodies = $prodiModel->findAll();

            $data = [
                'page'      => $this->pages,
                'user'      => $userUpdate,
                'roles'     => $roles,
                'prodies'   => $prodies,
            ];

            return view('pages/user/edit_user_view', $data);
        } catch (DataException $e) {
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $e) {
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        }
    }

    public function update($id)
    {
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $db->transBegin();
        try {
            //code...
            $role = $this->request->getPost('role');
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $phone = $this->request->getPost('phone');
            $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            $validationRule = [
                'username'  => 'required|max_length[200]',
                'email'     => 'required|valid_email',
                'phone'     => 'required|max_length[13]|min_length[11]',
            ];

            $dataToInsert = [
                'username'  => $username,
                'email'     => $email,
                'phone'     => $phone,
            ];

            //* Validate if the password is change
            if ($password) {
                $dataToInsert['password'] = password_hash($password, PASSWORD_DEFAULT);
                $validationRule['password'] = 'required|max_length[200]|min_length[8]';
            }

            //* Validate if role is mahasiswa
            if ($role == "4") {
                $validationRule['nim']          = 'required|max_length[12]|min_length[12]';
                $validationRule['birth_date']   = 'required';
                $validationRule['prodi_id']        = 'required';

                $dataToInsert['nim']        = $this->request->getPost('nim');
                $dataToInsert['birth_date'] = $this->request->getPost('birth_date');
                $dataToInsert['study_id']   = (int) $this->request->getPost('prodi');
            }

            if (! $this->validate($validationRule)) {
                $session->setFlashdata('error', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }

            $this->userModel->update($id, $dataToInsert);
            $db->transCommit();
            return redirect()->to(base_url('/a/admin/users'))->with(StateEnum::SUCCESS, 'Berhasil memperbaharui data user');
        } catch (DateException $e) {
            // Exception
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            //throw $th;
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }

    public function delete($id)
    {
        $session = \Config\Services::session();
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            if ($session->get('id') == $id) {
                throw new Exception("Tidak dapat mengapus user yang sedang digunakan", 400);
            }
            if ($this->userModel->delete($id)) {
                $db->transCommit();
                return redirect()->back()->with(StateEnum::SUCCESS, 'Berhasil menghapus user');
            }
            throw new Exception("Gagal menghapus user", 1);
        } catch (DateException $e) {
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        } catch (Exception $e) {
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
}
