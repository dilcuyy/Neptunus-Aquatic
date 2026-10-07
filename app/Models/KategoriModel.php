<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori_ikan';
    protected $primaryKey       = 'id_kategori';
    protected $allowedFields    = ['nama_kategori', 'sifat', 'tingkat_perawatan'];
    protected $returnType       = 'array';
}
