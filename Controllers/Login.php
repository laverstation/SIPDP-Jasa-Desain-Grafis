<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelPengelolaan;

class Login extends Controller
{
    public function index()
    {
        $validation = \Config\Services::validation();
        $this->_rules($validation);

        if (!$validation->run($this->request->getPost())) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            if (isset($username) && isset($password)) {
                session()->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Username dan Password Harus terisi!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
            }
            return view('login');
        } else {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $modelPengelolaan = new ModelPengelolaan();
            $cek = $modelPengelolaan->cek_login($username, $password);

            if ($cek === FALSE) {
                session()->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Username atau Password Salah!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
                return redirect()->to('login');
            } else {
                session()->set('id_hak', $cek->id_hak);
                session()->set('nama_pegawai', $cek->nama_pegawai);
                session()->set('photo', $cek->photo);
                session()->set('id_pegawai', $cek->id_pegawai);
                session()->set('nip', $cek->nip);
                switch ($cek->id_hak) {
                    case 1:
                        return redirect()->to('admin/dashboard');
                        break;
                    case 2:
                        return redirect()->to('pegawai/dashboard');
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function _rules($validation)
    {
        $validation->setRules([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            session()->setFlashdata('errors', $errors);
        };
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
