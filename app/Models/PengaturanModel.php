<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table            = 'pengaturan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['key_name', 'val_value'];
    protected $returnType       = 'array';

    public function getSetting($key, $default = '')
    {
        $row = $this->where('key_name', $key)->first();
        return $row ? $row['val_value'] : $default;
    }

    public function setSetting($key, $val)
    {
        $row = $this->where('key_name', $key)->first();
        if ($row) {
            return $this->update($row['id'], ['val_value' => $val]);
        }
        return $this->insert(['key_name' => $key, 'val_value' => $val]);
    }
}
