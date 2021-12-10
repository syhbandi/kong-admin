<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    private $email = "admin@misterkong.com";
    private $password = "Mataram@)@!";
    private $nama = "Administrator";

    public function index()
    {
        if ($this->session->has('login')) {
            return redirect()->to(base_url());
        }

        return view("login");
    }

    public function login()
    {
        $user = $this->request->getPost();
        if ($user['email'] == $this->email && $user['password'] == $this->password) {
            $this->session->set([
                'email' => $this->email,
                'nama' => $this->nama,
                'login' => true
            ]);

            return json_encode([
                'success' => true,
                'redirect' => base_url()
            ]);
        }

        return json_encode([
            'success' => false,
            'msg' => 'Email atau Password salah'
        ]);
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('auth'));
    }
}
