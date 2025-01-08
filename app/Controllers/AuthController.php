<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProgramStudyModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
use Exception;
use App\Enums\RoleEnum;
use App\Enums\StateEnum;

class AuthController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function index()
    {
        $session = \Config\Services::session();
        if ($session->get('isLoggedIn')) {
            return redirect()->to(base_url('a/'));
        }

        return view('auth/login_view');
    }

    public function login()
    {
        $session = \Config\Services::session();
        try {
            $email = $this->request->getPost("email");
            $password = $this->request->getPost("password");

            $loggedUser = $this->userModel->where('email', $email)->first();
            if ($loggedUser != null && password_verify($password, $loggedUser['password'])) {
                $ses_data = [
                    'id' => $loggedUser['id'],
                    'username' => $loggedUser['username'],
                    'role' => $loggedUser['role_id'],
                    'isLoggedIn' => true
                ];

                $session->set($ses_data);
                return redirect()->to(base_url('/a'));
            } else {
                return redirect()->back()->withInput()->with('error', 'Email atau password salah');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
    public function registerPage()
    {

        $session = \Config\Services::session();
        if ($session->get('isLoggedIn')) {
            return redirect()->to(base_url('a/'));
        }

        $prodiModel = new ProgramStudyModel();
        $roleModel = new RoleModel();

        $roles = $roleModel->whereNotIn('id', [RoleEnum::SUPER_ADMIN, RoleEnum::ADMINISTRATOR, RoleEnum::ACCOUNTING]);
        $data = [
            'prodies'   => $prodiModel->findAll(),
            'roles'     => $roles->findAll(),
        ];

        return view('auth/register_view', $data);
    }
    public function register()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        $userModel = new UserModel();
        try {
            $type = "outsider";

            $role       = $this->request->getPost('role_id');
            $name       = $this->request->getPost('username');
            $email      = $this->request->getPost('email');
            $password   = $this->request->getPost('password');
            $phone      = $this->request->getPost('phone');

            $dataToInsert = [
                'username'  => $name,
                'email'     => $email,
                'role_id'   => $role,
                'password'  => password_hash($password, PASSWORD_DEFAULT),
                'phone'     => $phone
            ];

            $validationRule = [
                'username'      => 'required|max_length[50]',
                'email'         => 'required|valid_email|is_unique[users.email,id]',
                'password'      => 'required|min_length[8]|max_length[200]',
                'role_id'       => 'required|numeric',
                'phone'         => 'required|min_length[12]'
            ];

            if ($role == 4) {
                //* Jika mendaftar sebagai mahasiswa
                $validationRule['nim']          = 'required|min_length[12]|max_length[12]';
                $validationRule['birth_date']   = 'required';
                $validationRule['study_id']     = 'required|numeric';

                $dataToInsert['nim']        = $this->request->getPost('nim');
                $dataToInsert['birth_date'] = $this->request->getPost('birth_date');
                $dataToInsert['study_id']   = $this->request->getPost('study_id');

                $type = "mahasiswa";
            }
            if (!$this->validate($validationRule)) {
                return redirect()->back()->withInput()->with(StateEnum::ERRORS, $this->validator->getErrors())->with('type', $type);
            }
            $userModel->insert($dataToInsert);
            $db->transCommit();
            return redirect()->to(base_url('auth/login'))->with(StateEnum::SUCCESS, 'Berhasil mendaftar');
        } catch (Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $e->getMessage());
        }
    }
    public function logout()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }
}
