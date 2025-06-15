<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\ModelPengelolaan;

class Data_Pegawai extends Controller
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

		$data['title'] = "Data Pegawai";
		$modelPengelolaan = new ModelPengelolaan();
		$data['pegawai'] = $modelPengelolaan->get_data('data_pegawai');
		$data['pegawai'] = $modelPengelolaan->getJabatan();

		echo view('template_admin/header', $data);
		echo view('template_admin/sidebar');
		echo view('admin/pegawai/data_pegawai', $data);
		echo view('template_admin/footer');
	}

	public function tambah_data()
	{
		$data['title'] = "Tambah Data Pegawai";
		$modelPengelolaan = new ModelPengelolaan();
		$data['id_jabatan'] = $modelPengelolaan->get_data('data_jabatan');

		echo view('template_admin/header', $data);
		echo view('template_admin/sidebar');
		echo view('admin/pegawai/tambah_dataPegawai', $data);
		echo view('template_admin/footer');
	}

	public function tambah_data_aksi()
	{
		$validation = \Config\Services::validation();
		$this->_rules_tambah_pegawai($validation);

		if (!$validation->run($this->request->getPost())) {
			return $this->tambah_data();
		} else {
			$nip = $this->request->getPost('nip');
			$nama_pegawai = $this->request->getPost('nama_pegawai');
			$username = $this->request->getPost('username');
			$password = md5($this->request->getPost('password'));
			$jenis_kelamin = $this->request->getPost('jenis_kelamin');
			$id_jabatan = $this->request->getPost('id_jabatan');
			$tanggal_masuk = $this->request->getPost('tanggal_masuk');
			$kontrak = $this->request->getPost('kontrak');
			$id_hak = $this->request->getPost('id_hak');
			$photo = $this->request->getFile('photo');

			if ($photo->isValid() && !$photo->hasMoved()) {
				$newName = 'pegawai-' . date('ymd') . '-' . md5(rand());
				$photo->move('./photo', $newName);
			}

			$data = [
				'nip' => $nip,
				'nama_pegawai' => $nama_pegawai,
				'username' => $username,
				'password' => $password,
				'jenis_kelamin' => $jenis_kelamin,
				'id_jabatan' => $id_jabatan,
				'tanggal_masuk' => $tanggal_masuk,
				'kontrak' => $kontrak,
				'id_hak' => $id_hak,
				'photo' => $newName,
			];

			$modelPengelolaan = new ModelPengelolaan();
			$modelPengelolaan->insert_data($data, 'data_pegawai');
			session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data berhasil ditambahkan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			return redirect()->to('admin/data_pegawai');
		}
	}

	public function update_data($id_pegawai)
	{
		$db = db_connect();
		$modelPengelolaan = new ModelPengelolaan();
		$where = ['id_pegawai' => $id_pegawai];
		$data['title'] = "Update Data Pegawai";
		$data['pegawai'] = $db->query("SELECT * FROM data_pegawai WHERE id_pegawai= '$id_pegawai'")->getResult();
		$data['id_jabatan'] = $modelPengelolaan->get_data('data_jabatan');

		echo view('template_admin/header', $data);
		echo view('template_admin/sidebar');
		echo view('admin/pegawai/update_dataPegawai', $data);
		echo view('template_admin/footer');
	}

	public function update_data_aksi()
	{
		$validation = \Config\Services::validation();
		$this->_rules_update_pegawai($validation);
		$id_pegawai = $this->request->getPost('id_pegawai');

		if (!$validation->run($this->request->getPost())) {
			return $this->update_data($id_pegawai);
		} else {
			$id_pegawai = $this->request->getPost('id_pegawai');
			$nip = $this->request->getPost('nip');
			$nama_pegawai = $this->request->getPost('nama_pegawai');
			$username = $this->request->getPost('username');
			$password = md5($this->request->getPost('password'));
			$jenis_kelamin = $this->request->getPost('jenis_kelamin');
			$id_jabatan = $this->request->getPost('id_jabatan');
			$tanggal_masuk = $this->request->getPost('tanggal_masuk');
			$kontrak = $this->request->getPost('kontrak');
			$id_hak = $this->request->getPost('id_hak');
			$photo = $this->request->getFile('photo');

			if ($photo->isValid() && !$photo->hasMoved()) {
				$newName = 'pegawai-' . date('ymd') . '-' . md5(rand());
				$photo->move('./photo', $newName);
			}

			$data = [
				'nip' => $nip,
				'nama_pegawai' => $nama_pegawai,
				'username' => $username,
				'password' => $password,
				'jenis_kelamin' => $jenis_kelamin,
				'id_jabatan' => $id_jabatan,
				'tanggal_masuk' => $tanggal_masuk,
				'kontrak' => $kontrak,
				'id_hak' => $id_hak,
				'photo' => $newName,
			];

			$modelPengelolaan = new ModelPengelolaan();
			$modelPengelolaan->update_data('data_pegawai', $data, ['id_pegawai' => $id_pegawai]);
			session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data berhasil diupdate!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			return redirect()->to('admin/data_pegawai');
		}
	}

	public function delete_data($id_pegawai)
	{
		$modelPengelolaan = new ModelPengelolaan();
		$where = ['id_pegawai' => $id_pegawai];
		$modelPengelolaan->delete_data($where, 'data_pegawai');
		session()->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Data berhasil dihapus!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		return redirect()->to('admin/data_pegawai');
	}

	protected function _rules_tambah_pegawai($validation)
	{
		$validation->setRules([
			'nip' => 'required|is_unique[data_pegawai.nip]',
			'nama_pegawai' => 'required',
			'username' => 'required',
			'password' => 'required|min_length[8]|regex_match[/(?=.*[A-Z])(?=.*\d)/]',
			'jenis_kelamin' => 'required',
			'tanggal_masuk' => 'required',
			'id_jabatan' => 'required',
			'kontrak' => 'required',
			'id_hak' => 'required',
		]);
		if (!$validation->withRequest($this->request)->run()) {
			$errors = $validation->getErrors();


			$customErrors = [];
			$form_label = array(
				"nip" => "NIP",
				'nama_pegawai' => 'Nama Pegawai',
				'username' => 'Username',
				'password' => 'Password',
				'jenis_kelamin' => 'Jenis Kelamin',
				'tanggal_masuk' => 'Tanggal Masuk',
				'id_jabatan' => 'Jabatan',
				'kontrak' => 'Kontrak',
				'id_hak' => 'Hak Akses',
				'photo' => 'Foto',
			);
			foreach ($errors as $field => $message) {
				switch ($message) {
					case 'The ' . $field . ' field is required.':
						$customErrors[$field] = $form_label[$field] . ' harus diisi.';
						break;
					case 'The ' . $field . ' field must contain a unique value.':
						$customErrors[$field] =  $form_label[$field] . ' harus bersifat unik.';
						break;
					case 'The ' . $field . ' field must be at least 8 characters in length.':
						$customErrors[$field] =  $form_label[$field] . ' minimal 8 karakter.';
						break;
					case 'The ' . $field . ' field is not in the correct format.':
						$customErrors[$field] =  $form_label[$field] . ' harus punya 1 huruf besar dan 1 angka.';
						break;
					default:
						$customErrors[$field] = $message;
						break;
				}
			}

			session()->setFlashdata('errors', $customErrors);
		}
	}

	protected function _rules_update_pegawai($validation)
	{
		$validation->setRules([
			'nip' => 'required',
			'nama_pegawai' => 'required',
			'username' => 'required',
			'password' => 'required|min_length[8]|regex_match[/(?=.*[A-Z])(?=.*\d)/]',
			'jenis_kelamin' => 'required',
			'tanggal_masuk' => 'required',
			'id_jabatan' => 'required',
			'kontrak' => 'required',
			'id_hak' => 'required',
		]);
		if (!$validation->withRequest($this->request)->run()) {
			$errors = $validation->getErrors();

			$customErrors = [];
			$form_label = array(
				"nip" => "NIP",
				'nama_pegawai' => 'Nama Pegawai',
				'username' => 'Username',
				'password' => 'Password',
				'jenis_kelamin' => 'Jenis Kelamin',
				'tanggal_masuk' => 'Tanggal Masuk',
				'id_jabatan' => 'Jabatan',
				'kontrak' => 'Kontrak',
				'id_hak' => 'Hak Akses',
			);
			foreach ($errors as $field => $message) {
				switch ($message) {
					case 'The ' . $field . ' field is required.':
						$customErrors[$field] = $form_label[$field] . ' harus diisi kembali.';
						break;
					case 'The ' . $field . ' field must contain a unique value.':
						$customErrors[$field] = $form_label[$field] . ' harus bersifat unik.';
						break;
					case 'The ' . $field . ' field must be at least 8 characters in length.':
						$customErrors[$field] =  $form_label[$field] . ' minimal 8 karakter.';
						break;
					case 'The ' . $field . ' field is not in the correct format.':
						$customErrors[$field] =  $form_label[$field] . ' harus punya 1 huruf besar dan 1 angka.';
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
