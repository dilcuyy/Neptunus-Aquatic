<?php

namespace App\Controllers;

use App\Models\PengaturanModel;

class Pengaturan extends BaseController
{
    public function get()
    {
        $model = new PengaturanModel();
        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'nama_toko'   => $model->getSetting('nama_toko', 'Neptunus Aquatic'),
                'sub_title'   => $model->getSetting('sub_title', 'Manager Operasional'),
                'stok_kritis' => $model->getSetting('stok_kritis', '5')
            ]
        ]);
    }

    public function update()
    {
        $model = new PengaturanModel();
        $namaToko   = trim($this->request->getPost('nama_toko'));
        $subTitle   = trim($this->request->getPost('sub_title'));
        $stokKritis = trim($this->request->getPost('stok_kritis'));

        if (!empty($namaToko)) {
            $model->setSetting('nama_toko', $namaToko);
        }
        if (!empty($subTitle)) {
            $model->setSetting('sub_title', $subTitle);
        }
        if (!empty($stokKritis)) {
            $model->setSetting('stok_kritis', $stokKritis);
        }

        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => 'Pengaturan aplikasi berhasil disimpan!',
            'nama_toko' => $namaToko ?: 'Neptunus Aquatic',
            'sub_title' => $subTitle ?: 'Manager Operasional'
        ]);
    }
}
