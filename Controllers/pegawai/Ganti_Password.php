<?php

namespace App\Controllers\Pegawai;

use CodeIgniter\Controller;

use App\Models\ModelPengelolaan;

class Ganti_Password extends Controller
{
	public function index()
	{
		$data['title'] = "Form Ganti Password";

		return view('template_pegawai/header', $data)
			. view('template_pegawai/sidebar')
			. view('pegawai/ganti_password', $data)
			. view('template_pegawai/footer');
	}

	public function ganti_password_aksi()
	{

		$validation = \Config\Services::validation();
		$this->_rules_password($validation);
		$ModelPengelolaan = new ModelPengelolaan();

		$passBaru = $this->request->getPost('passBaru');
		$ulangPass = $this->request->getPost('ulangPass');

		if (!$validation->run($this->request->getPost())) {
			return $this->index();
		} else {
			$data = ['password' => md5($passBaru)];
			$id = ['id_pegawai' => session()->get('id_pegawai')];
			$ModelPengelolaan->update_data('data_pegawai', $data, $id);
			session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Password berhasil diganti!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			return redirect()->to('login');
		}
	}

	protected function _rules_password($validation)
	{
		$validation->setRules([
			'passBaru' => 'required|min_length[8]|regex_match[/(?=.*[A-Z])(?=.*\d)/]',
			'ulangPass' => 'required|matches[passBaru]',

		]);
		if (!$validation->withRequest($this->request)->run()) {
			$errors = $validation->getErrors();
			$customErrors = [];
			$form_label = array(
				"passBaru" => "Password baru",
				'ulangPass' => 'Ulangi password baru',
			);
			foreach ($errors as $field => $message) {
				switch ($message) {
					case 'The ' . $field . ' field is required.':
						$customErrors[$field] = $form_label[$field] . ' harus diisi.';
						break;
					case 'The ' . $field . ' field does not match the passBaru field.':
						$customErrors[$field] = 'Password tidak sama';
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
