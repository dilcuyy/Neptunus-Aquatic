<?php

namespace App\Models;

use CodeIgniter\Model;

class AkunModel extends Model
{
    protected $table            = 'akun';
    protected $primaryKey       = 'id_akun';
    protected $allowedFields    = ['username', 'password', 'nama_lengkap', 'role', 'nomor_hp', 'foto'];
    protected $returnType       = 'array';
}
