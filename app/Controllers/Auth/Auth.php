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
        $data = array(
            'title' => 'Login',
        );
        return view('auth/login', $data);
    }

    public function login()
    {
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }

        // $data = [];
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'username' => [
                'label'     => 'Username',
                'rules'     => 'required|max_length[20]',
                'errors' => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'password' => [
                'label'     => 'Password',
                'rules'     => 'required|max_length[255]|validateLogin[username,password]',
                'errors' => [
                    'max_length' => '{field} Maksimal 255 Karakter',
                    'validateLogin' => 'Username Or Passoword Not Match,Please try Again.',
                ],
            ],
        ]);



        if (!$valid) {
            /**
             *'kode' => $validation->getError('kodeAddEdit'),
             * 'kode' -> id or class to display error
             * 'kodeAddEdit' -> name field that ajax send
             */
            $data = [
                'error' => [
                    'username' => $validation->getError('username'),
                    'password' => $validation->getError('password'),
                ],
                'msg' => 'Username Or Passoword Not Match,Please try Again.',
            ];
        } else {
            // $data = "";
            $user =  $this->pegawai->where('username', $this->request->getVar('username'))->first();
            $this->setUserSession($user);

            // Redirecting to dashboard after login
            if($user['level'] == "Admin"){
                $data = array('success' => true, 'msg' => 'Selamat Datang '.$user['level'].'', 'redirect' => base_url('admin'));

            }elseif($user['level'] == "Kepala Bidang"){
                $data = array('success' => true, 'msg' => 'Selamat Datang '.$user['level'].'', 'redirect' => base_url('kepala'));
            }
            elseif($user['level'] == "Bendahara"){
                $data = array('success' => true, 'msg' => 'Selamat Datang '.$user['level'].'', 'redirect' => base_url('bendahara'));
            }
            elseif($user['level'] == "Pegawai"){
                $data = array('success' => true, 'msg' => 'Selamat Datang '.$user['level'].'', 'redirect' => base_url('pegawai'));
            }
        }
        $data['msg'] = $data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($data);

    }

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'username' => $user['username'],
            'nip' => $user['nip'],
            'isLoggedIn' => true,
            "level" => $user['level'],
        ];

        session()->set($data);
        return true;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('auth'))->with('success', 'You have been logged out!');
    }
    public function forbidden()
    {
        return view('auth/error_403');
    }
}
