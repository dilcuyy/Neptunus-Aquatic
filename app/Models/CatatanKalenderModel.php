<?php

namespace App\Models;

use CodeIgniter\Model;

class CatatanKalenderModel extends Model
{
    protected $table            = 'catatan_kalender';
    protected $primaryKey       = 'id_catatan';
    protected $allowedFields    = ['tanggal', 'catatan', 'updated_at'];
    protected $returnType       = 'array';
}
