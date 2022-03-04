<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\Admin\PegawaiModel;

class Auth extends BaseController
{
    protected $helpers = ['form', 'url', 'text'];
    public function __construct()
    {
        $this->pegawai = new PegawaiModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
        $this->session = \Config\Services::session();
        $this->session->start();
    }
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $data = [];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|',
                'password' => 'required|min_length[8]|max_length[255]|validateUser[username,password]',
            ];

            $errors = [
                'password' => [
                    'validateUser' => "Some Thing Wrong",
                ],
            ];

            if (!$this->validate($rules, $errors)) {

                return view('auth', [
                    "validation" => $this->validator,
                ]);

            } else {

                $user =  $this->pegawai->where('username', $this->request->getVar('username'))
                    ->first();

                // Stroing session values
                $this->setUserSession($user);


                // Redirecting to dashboard after login
                if($user['role'] == "admin"){

                    return redirect()->to(base_url('admin'));

                }elseif($user['role'] == "editor"){

                    return redirect()->to(base_url('editor'));
                }
            }
        }
        return view('login');
    }

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'name' => $user['name'],
            'phone_no' => $user['phone_no'],
            'email' => $user['email'],
            'isLoggedIn' => true,
            "role" => $user['role'],
        ];

        session()->set($data);
        return true;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
