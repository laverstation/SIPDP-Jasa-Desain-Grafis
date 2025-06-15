<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\ModelJob;

class Data_Job extends Controller
{

	public function __construct()
	{
		if (session()->get('id_hak') != '1') {
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

		$data['title'] = "Data Job";
		$modelJob = new ModelJob();
		$data['job'] = $modelJob->get_data('data_job');
		$data['job'] = $modelJob->getPegawai();

		echo view('template_admin/header', $data);
		echo view('template_admin/sidebar');
		echo view('admin/job/data_job', $data);
		echo view('template_admin/footer');
	}

	public function tambah_data()
	{
		$data['title'] = "Tambah Data Job";
		$modelJob = new ModelJob();
		$data['id_jabatan'] = $modelJob->get_data('data_jabatan');
		$data['id_pegawai'] = $modelJob->get_data('data_pegawai');

		echo view('template_admin/header', $data);
		echo view('template_admin/sidebar');
		echo view('admin/job/tambah_dataJob', $data);
		echo view('template_admin/footer');
	}

	public function tambah_data_aksi()
	{
		$validation = \Config\Services::validation();
		$this->_rules_tambah_job($validation);

		if (!$validation->run($this->request->getPost())) {
			return $this->tambah_data();
		} else {
			$id_jabatan = $this->request->getPost('id_jabatan');
			$id_pegawai = $this->request->getPost('id_pegawai');
			$detail_job = $this->request->getPost('detail_job');
			$harga_job = $this->request->getPost('harga_job');
			$tgl_deadline = $this->request->getPost('tgl_deadline');

			$data = [
				'id_jabatan' => $id_jabatan,
				'id_pegawai' => $id_pegawai,
				'detail_job' => $detail_job,
				'harga_job' => $harga_job,
				'tgl_deadline' => $tgl_deadline,
			];

			$modelJob = new ModelJob();
			$modelJob->insert_data($data, 'data_job');
			session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data berhasil ditambahkan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			return redirect()->to('admin/data_job');
		}
	}

	public function upload_process_design()
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
				return redirect()->to('admin/data_job');
			} else {
				echo "Error uploading the file.";
			}
		}
	}

	public function upload_process_revisi()
	{
		if ($this->request->getMethod() === 'post') {
			$file = $this->request->getFile('file');

			if ($file->isValid() && !$file->hasMoved()) {
				$originalName = $file->getName();
				$file->move(ROOTPATH . 'public/uploads', $originalName);

				$idJob = $this->request->getPost('id_job');
				$modelJob = new ModelJob();
				$data = ['revisi' => $originalName];
				$where = ['id_job' => $idJob];
				$modelJob->update_data('data_job', $data, $where);
				return redirect()->to('admin/data_job');
			} else {
				echo "Error uploading the file.";
			}
		}
	}

	public function form_revisi($id_job)
	{
		$db = db_connect();
		$modelJob = new ModelJob();
		$where = ['id_job' => $id_job];
		$data['title'] = "Submit Detail Revisi";
		$data['job'] = $db->query("SELECT * FROM data_job WHERE id_job= '$id_job'")->getResult();
		$data['id_jabatan'] = $modelJob->get_data('data_jabatan');
		$data['id_pegawai'] = $modelJob->get_data('data_pegawai');

		echo view('template_admin/header', $data);
		echo view('template_admin/sidebar');
		echo view('admin/job/form_revisiJob', $data);
		echo view('template_admin/footer');
	}

	public function form_revisi_aksi()
	{
		$validation = \Config\Services::validation();
		$this->_rules_revisi($validation);
		$id_job = $this->request->getPost('id_job');

		if (!$validation->run($this->request->getPost())) {
			return $this->form_revisi($id_job);
		} else {
			$id_job = $this->request->getPost('id_job');
			$id_jabatan = $this->request->getPost('id_jabatan');
			$id_pegawai = $this->request->getPost('id_pegawai');
			$detail_job = $this->request->getPost('detail_job');
			$harga_job = $this->request->getPost('harga_job');
			$tgl_deadline = $this->request->getPost('tgl_deadline');
			$detail_revisi = $this->request->getPost('detail_revisi');

			$data = [
				'id_jabatan' => $id_jabatan,
				'id_pegawai' => $id_pegawai,
				'detail_job' => $detail_job,
				'harga_job' => $harga_job,
				'tgl_deadline' => $tgl_deadline,
				'detail_revisi' => $detail_revisi,
			];

			$modelJob = new ModelJob();
			$modelJob->update_data('data_job', $data, ['id_job' => $id_job]);
			session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Revisi Berhasil Diinput!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			return redirect()->to('admin/data_job');
		}
	}

	public function delete_data($id_job)
	{
		$modelJob = new ModelJob();
		$where = ['id_job' => $id_job];
		$modelJob->delete_data($where, 'data_job');
		session()->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Data berhasil dihapus!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		return redirect()->to('admin/data_job');
	}

	public function update_status()
	{
		if ($this->request->getMethod() === 'post') {
			$idJob = $this->request->getPost('id_job');
			$status = $this->request->getPost('status');
			$modelJob = new ModelJob();
			$data = ['status' => $status];
			$where = ['id_job' => $idJob];
			$modelJob->update_data('data_job', $data, $where);
			return redirect()->to('admin/data_job');
		}
	}

	protected function _rules_tambah_job($validation)
	{
		$validation->setRules([
			'id_jabatan' => 'required',
			'id_pegawai' => 'required',
			'detail_job' => 'required',
			'harga_job' => 'required',
			'tgl_deadline' => 'required',
		]);

		if (!$validation->withRequest($this->request)->run()) {
			$errors = $validation->getErrors();

			// Customize error messages
			$customErrors = [];
			$form_label = array(
				'id_jabatan' => 'Kategori',
				'id_pegawai' => 'Pegawai',
				'detail_job' => 'Detail Job',
				'harga_job' => 'Harga',
				'tgl_deadline' => 'Tanggal Deadline',
			);
			foreach ($errors as $field => $message) {
				switch ($message) {
					case 'The ' . $field . ' field is required.':
						$customErrors[$field] = $form_label[$field] . ' harus diisi.';
						break;
					default:
						$customErrors[$field] = $message;
						break;
				}
			}
			session()->setFlashdata('errors', $customErrors);
		}
	}

	protected function _rules_revisi($validation)
	{
		$validation->setRules([
			'detail_revisi' => 'required',
		]);

		if (!$validation->withRequest($this->request)->run()) {
			$errors = $validation->getErrors();

			$customErrors = [];
			$form_label = array(
				'detail_revisi' => 'Detail Revisi',
			);
			foreach ($errors as $field => $message) {
				switch ($message) {
					case 'The ' . $field . ' field is required.':
						$customErrors[$field] = $form_label[$field] . ' harus diisi.';
						break;
					default:
						$customErrors[$field] = $message;
						break;
				}
			}
			session()->setFlashdata('errors', $customErrors);
		}
	}
}
