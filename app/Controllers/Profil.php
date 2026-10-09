<?php

namespace App\Controllers;

use App\Models\AkunModel;

class Profil extends BaseController
{
    public function get()
    {
        $akunModel = new AkunModel();
        // Get primary admin account (id_akun = 1)
        $user = $akunModel->find(1);
        if (!$user) {
            $user = [
                'id_akun'      => 1,
                'username'     => 'admin',
                'nama_lengkap' => 'Admin Neptunus',
                'role'         => 'admin',
                'nomor_hp'     => '081234567890',
                'foto'         => '1.jpg'
            ];
        }

        $fotoUrl = base_url('assets/images/avatars/' . ($user['foto'] ?? '1.jpg'));
        if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/profile/' . $user['foto'])) {
            $fotoUrl = base_url('uploads/profile/' . $user['foto']);
        }

        return $this->response->setJSON([
            'status'   => 'success',
            'data'     => $user,
            'foto_url' => $fotoUrl
        ]);
    }

    public function update()
    {
        $akunModel = new AkunModel();
        $idAkun    = $this->request->getPost('id_akun') ?: 1;

        $namaLengkap = substr(trim($this->request->getPost('nama_lengkap') ?? ''), 0, 100);
        $username    = substr(trim($this->request->getPost('username') ?: 'admin'), 0, 50);
        $nomorHp     = substr(trim($this->request->getPost('nomor_hp') ?? ''), 0, 20);

        if (empty($namaLengkap)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Nama lengkap tidak boleh kosong.'
            ]);
        }

        $dataUpdate = [
            'nama_lengkap' => $namaLengkap,
            'username'     => $username,
            'nomor_hp'     => $nomorHp
        ];

        // Handle profile photo upload if provided
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/profile/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $newName);
            $dataUpdate['foto'] = $newName;
        }

        $akunModel->update($idAkun, $dataUpdate);
        $userUpdated = $akunModel->find($idAkun);

        $fotoUrl = base_url('assets/images/avatars/' . ($userUpdated['foto'] ?? '1.jpg'));
        if (!empty($userUpdated['foto']) && file_exists(FCPATH . 'uploads/profile/' . $userUpdated['foto'])) {
            $fotoUrl = base_url('uploads/profile/' . $userUpdated['foto']);
        }

        return $this->response->setJSON([
            'status'       => 'success',
            'message'      => 'Profil administrator berhasil diperbarui!',
            'nama_lengkap' => $userUpdated['nama_lengkap'],
            'foto_url'     => $fotoUrl
        ]);
    }
}
