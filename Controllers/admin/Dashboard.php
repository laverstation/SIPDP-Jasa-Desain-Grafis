<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Dashboard extends Controller
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
		// Akses Field Yang Ditampilkan
		$db = db_connect();
		$currentDate = date("Y-m-d");
		$selesai = $db->query("SELECT status FROM data_job WHERE status = 'Selesai' AND tgl_deadline <= '$currentDate'");
		$revisi = $db->query("SELECT status FROM data_job WHERE status = 'Revisi' AND tgl_deadline <= '$currentDate'");
		$progress = $db->query("SELECT status FROM data_job WHERE status = 'On Progress' AND tgl_deadline <= '$currentDate'");
		$deadline = $db->query("SELECT tgl_deadline FROM data_job WHERE tgl_deadline <= '$currentDate' AND status != 'Selesai'");

		// Ambil Data dari Field database
		$data['title'] = "Dashboard";
		$data['selesai'] = $selesai->getNumRows();
		$data['revisi'] = $revisi->getNumRows();
		$data['progress'] = $progress->getNumRows();
		$data['deadline'] = $deadline->getNumRows();

		// Keperluan Grafik
		$data['queryAnimasi'] = $db->query("SELECT MONTH(tgl_mulai) as bulan, SUM(harga_job) AS total_pendapatan_animasi FROM data_job WHERE id_jabatan = 1 GROUP BY MONTH(tgl_mulai)")->getResult();
		$data['queryIllustrasi'] = $db->query("SELECT MONTH(tgl_mulai) as bulan, SUM(harga_job) AS total_pendapatan_illustrasi FROM data_job WHERE id_jabatan = 2 GROUP BY MONTH(tgl_mulai)")->getResult();
		$data['query3D'] = $db->query("SELECT MONTH(tgl_mulai) as bulan, SUM(harga_job) AS total_pendapatan_3d FROM data_job WHERE id_jabatan = 7 GROUP BY MONTH(tgl_mulai)")->getResult();

		$data['larisAnimasiCount'] = $db->query("SELECT id_jabatan FROM data_job WHERE id_jabatan= 1")->getNumRows();
		$data['larisIllustrasiCount'] = $db->query("SELECT id_jabatan FROM data_job WHERE id_jabatan= 2")->getNumRows();
		$data['laris3DCount'] = $db->query("SELECT id_jabatan FROM data_job WHERE id_jabatan= 7")->getNumRows();
		//echo $queryAnimasi[0]->total_pendapatan_animasi;

		return view('template_admin/header', $data)
			. view('template_admin/sidebar')
			. view('admin/dashboard', $data)
			. view('template_admin/footer', $data);
	}
}
