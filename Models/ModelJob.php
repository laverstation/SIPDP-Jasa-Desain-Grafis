<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJob extends Model
{
    protected $table = 'data_job';
    protected $primaryKey = 'id_job';
    protected $allowedFields = ['id_jabatan', 'id_pegawai', 'detail_job', 'harga_job', 'tgl_mulai', 'tgl_deadline', 'desain', 'status', 'revisi', 'detail_revisi'];

    public function get_data($table)
    {
        return $this->db->table($table)->get()->getResult();
    }

    public function get_where($table, $where)
    {
        return $this->db->table($table)->where($where)->get()->getResult();
    }

    public function insert_data($data, $table)
    {
        $this->db->table($table)->insert($data);
    }

    public function update_data($table, $data, $where)
    {
        $this->db->table($table)->update($data, $where);
    }

    public function delete_data($where, $table)
    {
        $this->db->table($table)->where($where)->delete();
    }

    public function cek_login()
    {
        $username = request()->getPost('username');
        $password = request()->getPost('password');

        $result = $this->db->table($this->table)
            ->where('username', $username)
            ->where('password', md5($password))
            ->limit(1)
            ->get();

        if ($result->getNumRows() > 0) {
            return $result->getRow();
        } else {
            return false;
        }
    }
    public function getPegawai()
    {
        $query = $this->db->table('data_job')
            ->join('data_jabatan', 'data_jabatan.id_jabatan = data_job.id_jabatan')
            ->join('data_pegawai', 'data_pegawai.id_pegawai = data_job.id_pegawai')
            ->get();

        return $query->getResult();
    }
}
