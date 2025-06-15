<?php

namespace App\Controllers\Pegawai;

use CodeIgniter\Controller;
use App\Models\ModelPengelolaan;

class Dashboard extends Controller
{
	public function __construct()
	{
		if (session()->get('hak_akses') != '2') {
			session()->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Anda Belum Login!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			return redirect()->to('login');
		}
	}

	public function index()
	{
		$data['title'] = "Dashboard";
		$db = db_connect();
		$id_pegawai = session()->get('id_pegawai');
		$data['pegawai'] = $db->query("SELECT * FROM data_pegawai WHERE id_pegawai = '$id_pegawai'")->getResult();

		return view('template_pegawai/header', $data)
			. view('template_pegawai/sidebar')
			. view('pegawai/dashboard', $data)
			. view('template_pegawai/footer');
	}
}
