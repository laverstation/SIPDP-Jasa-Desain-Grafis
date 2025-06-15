<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengelolaan extends Model
{
    protected $table = 'data_pegawai';
    protected $primaryKey = 'id_pegawai';
    protected $allowedFields = ['nama_pegawai', 'username', 'password', 'id_hak', 'id_jabatan', 'photo', 'nip', 'tanggal_masuk', 'kontrak', 'jenis_kelamin'];

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
    public function getJabatan()
    {
        $query = $this->db->table('data_pegawai')
            ->join('data_jabatan', 'data_jabatan.id_jabatan = data_pegawai.id_jabatan')
            ->join('hak_akses', 'hak_akses.id_hak = data_pegawai.id_hak')
            ->select('data_pegawai.*, data_jabatan.jabatan')
            ->get();

        return $query->getResult();
    }
}
