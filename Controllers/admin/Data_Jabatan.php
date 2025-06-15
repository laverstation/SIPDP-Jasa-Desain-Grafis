<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\ModelPengelolaan;

class Data_Jabatan extends Controller
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
		$data['title'] = "Data Jabatan";
		$ModelPengelolaan = new ModelPengelolaan();
		$data['id_jabatan'] = $ModelPengelolaan->get_data('data_jabatan');

		echo view('template_admin/header', $data);
		echo view('template_admin/sidebar');
		echo view('admin/jabatan/data_jabatan', $data);
		echo view('template_admin/footer');
	}

	public function tambah_data()
	{
		$data['title'] = "Tambah Data Jabatan";

		echo view('template_admin/header', $data);
		echo view('template_admin/sidebar');
		echo view('admin/jabatan/tambah_dataJabatan', $data);
		echo view('template_admin/footer');
	}

	public function tambah_data_aksi()
	{
		$validation = \Config\Services::validation();
		$this->_rules_jabatan($validation);

		if (!$validation->run($this->request->getPost())) {
			return $this->tambah_data();
		} else {
			$jabatan = $this->request->getPost('jabatan');

			$data = [
				'jabatan' => $jabatan,
			];
			$ModelPengelolaan = new ModelPengelolaan();
			$ModelPengelolaan->insert_data($data, 'data_jabatan');
			session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Data berhasil ditambahkan!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
			return redirect()->to('admin/data_jabatan');
		}
	}

	public function update_data($id_jabatan)
	{
		$db = db_connect();
		$where = ['id_jabatan' => $id_jabatan];
		$data['jabatan'] = $db->query("SELECT * FROM data_jabatan WHERE id_jabatan= '$id_jabatan'")->getResult();
		$data['title'] = "Update Data Jabatan";

		echo view('template_admin/header', $data);
		echo view('template_admin/sidebar');
		echo view('admin/jabatan/update_dataJabatan', $data);
		echo view('template_admin/footer');
	}

	public function update_data_aksi()
	{
		$validation = \Config\Services::validation();
		$this->_rules_jabatan($validation);

		if (!$validation->run($this->request->getPost())) {
			$this->update_data();
		} else {
			$jabatan = $this->request->getPost('jabatan');
			$id_jabatan = $this->request->getPost('id_jabatan');

			$data = [
				'jabatan' => $jabatan,
			];

			$where = ['id_jabatan' => $id_jabatan];
			$ModelPengelolaan = new ModelPengelolaan();
			$ModelPengelolaan->update_data('data_jabatan', $data, $where);
			session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Data berhasil diupdate!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
			return redirect()->to('admin/data_jabatan');
		}
	}

	public function delete_data($id_jabatan)
	{
		$where = ['id_jabatan' => $id_jabatan];
		$ModelPengelolaan = new ModelPengelolaan();
		$ModelPengelolaan->delete_data($where, 'data_jabatan');
		session()->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data berhasil dihapus!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
		return redirect()->to('admin/data_jabatan');
	}

	protected function _rules_jabatan($validation)
	{
		$validation->setRules([
			'jabatan' => 'required',
		]);
		if (!$validation->withRequest($this->request)->run()) {
			$errors = $validation->getErrors();

			$customErrors = [];
			$form_label = array(
				"jabatan" => "Jabatan",
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
