<?php

namespace App\Controllers\Pegawai;

use CodeIgniter\Controller;
use App\Models\ModelJob;

class Job extends Controller
{

	public function __construct()
	{
		if (session()->get('id_hak') != '2') {
			session()->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Anda Belum Login!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			header("Location: " . site_url() . '/login');
			die();
		}
	}

	public function index()
	{

		$data['title'] = "Job";
		$modelJob = new ModelJob();
		$id_pegawai = session()->get('id_pegawai');
		$where = ['id_pegawai' => $id_pegawai];
		$data['job'] = $modelJob->get_where('data_job', $where);

		echo view('template_pegawai/header', $data);
		echo view('template_pegawai/sidebar');
		echo view('pegawai/job', $data);
		echo view('template_pegawai/footer');
	}
	public function upload_process()
	{
		if ($this->request->getMethod() === 'post') {
			$file = $this->request->getFile('file');

			if ($file->isValid() && !$file->hasMoved()) {
				$originalName = $file->getName();
				$file->move(ROOTPATH . 'public/uploads', $originalName);

				$idJob = $this->request->getPost('id_job');
				$modelJob = new ModelJob();
				$data = ['desain' => $originalName];
				$where = ['id_job' => $idJob];
				$modelJob->update_data('data_job', $data, $where);
				return redirect()->to('pegawai/job');
			} else {
				echo "Error uploading the file.";
			}
		}
	}
}
