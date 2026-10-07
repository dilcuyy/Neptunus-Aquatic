<?php

namespace App\Models;

use CodeIgniter\Model;

class IkanModel extends Model
{
    protected $table            = 'ikan';
    protected $primaryKey       = 'id_ikan';
    protected $allowedFields    = ['id_kategori', 'nama_ikan', 'harga_beli', 'harga_jual', 'stok', 'deskripsi', 'foto', 'gambar'];
    protected $returnType       = 'array';

    public function getIkanWithKategori($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ikan.*, kategori_ikan.nama_kategori, kategori_ikan.sifat, kategori_ikan.tingkat_perawatan');
        $builder->join('kategori_ikan', 'kategori_ikan.id_kategori = ikan.id_kategori', 'left');

        if ($id !== null) {
            $builder->where('ikan.id_ikan', $id);
            return $builder->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }
}
