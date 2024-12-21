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

class AuthController extends BaseController
{
    protected Model|null $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function index()
    {
        //

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

            // dd([$email, $password]);
            $loggedUser = $this->userModel->where('email', $email)->first();
            // dd(['pass', $password, $loggedUser['password'], password_verify($password, $loggedUser['password'])]);
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
                throw new Exception("Email or Password is invalid", 400);
            }
        } catch (\Exception $e) {
            $session->setFlashdata('error', $e->getMessage());
            return redirect()->to(base_url('/auth/login'));
        }
    }
    public function registerPage()
    {

        $session = \Config\Services::session();
        if ($session->get('isLoggedIn')) {
            return redirect()->to(base_url('a/'));
        }

        $prodiModel = new ProgramStudyModel();
        $data = [
            'prodies' => $prodiModel->findAll()
        ];
        return view('auth/register_view', $data);
    }
    public function register()
    {
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $db->transBegin();
        $userModel = new UserModel();
        try {
            $role       = $this->request->getPost('role_id');
            $name       = $this->request->getPost('username');
            $email      = $this->request->getPost('email');
            $password   = $this->request->getPost('password');

            $dataToInsert = [
                'username'  => $name,
                'email'     => $email,
                'role_id'   => $role,
                'password'  => password_hash($password, PASSWORD_DEFAULT),
            ];

            $validationRule = [
                'username'      => 'required|max_length[50]',
                'email'         => 'required|valid_email|is_unique[users.email,id]',
                'password'      => 'required|min_length[8]|max_length[200]',
                'role_id'       => 'required|numeric'
            ];

            if ($role == 4) {
                //* Jika mendaftar sebagai mahasiswa
                $validationRule['phone']        = 'required|min_length[12]';
                $validationRule['nim']          = 'required|min_length[12]|max_length[12]';
                $validationRule['birth_date']   = 'required';
                $validationRule['study_id']     = 'required|numeric';

                $dataToInsert['phone']      = $this->request->getPost('phone');
                $dataToInsert['nim']        = $this->request->getPost('nim');
                $dataToInsert['birth_date'] = $this->request->getPost('birth_date');
                $dataToInsert['study_id']   = $this->request->getPost('study_id');
            }
            if (!$this->validate($validationRule)) {
                // dd(array_merge($dataToInsert, ['atas'], ['error' => $this->validator->getErrors()]));
                $session->setFlashdata('error', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }
            // dd(array_merge($dataToInsert, ['bawah']));
            $userModel->insert($dataToInsert);
            $db->transCommit();
            $session->set('alert', 'Pendaftaran sukses');
            return redirect()->to(base_url('auth/login'));
        } catch (Exception $e) {
            $db->transRollback();
            $session->setFlashdata('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    public function logout()
    {
        $session = \Config\Services::session();
        $session->destroy();
        // dd($session->get('isLoggedIn'));
        return redirect()->to(base_url('/'));
    }
}
