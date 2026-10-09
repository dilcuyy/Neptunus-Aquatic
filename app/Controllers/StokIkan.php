<?php

namespace App\Controllers;

use App\Models\IkanModel;
use App\Models\KategoriModel;

class StokIkan extends BaseController
{
    public function index()
    {
        $ikanModel = new IkanModel();
        $kategoriModel = new KategoriModel();

        $fishList = $ikanModel->getIkanWithKategori();
        $kategoriList = $kategoriModel->findAll();

        $pengaturanModel = new \App\Models\PengaturanModel();
        $batasKritis = (int) $pengaturanModel->getSetting('stok_kritis', '5');
        if ($batasKritis < 1) $batasKritis = 5;

        foreach ($fishList as &$fish) {
            $stok = (int) $fish['stok'];
            if ($stok <= 0) {
                $fish['status_stok'] = 'Habis';
                $fish['badge'] = 'bg-danger';
            } elseif ($stok <= $batasKritis) {
                $fish['status_stok'] = 'Kritis';
                $fish['badge'] = 'bg-danger';
            } else {
                $fish['status_stok'] = 'Aman';
                $fish['badge'] = 'bg-success';
            }
        }

        $data = [
            'title'        => 'Stok',
            'description'  => 'Manajemen & kelola data stok barang secara lengkap (CRUD).',
            'heading_icon' => 'pe-7s-box2',
            'activeMenu'   => 'stok_ikan',
            'fish_list'    => $fishList,
            'kategori_list'=> $kategoriList,
            'batas_kritis' => $batasKritis
        ];

        return view('stok_ikan/index', $data);
    }

    public function simpan()
    {
        $ikanModel = new IkanModel();

        $saveData = [
            'nama_ikan'   => substr(trim($this->request->getPost('nama_ikan') ?? ''), 0, 100),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'harga_beli'  => min(max((float) preg_replace('/\D/', '', (string) $this->request->getPost('harga_beli')), 0), 999999999),
            'harga_jual'  => min(max((float) preg_replace('/\D/', '', (string) $this->request->getPost('harga_jual')), 0), 999999999),
            'stok'        => min(max((int) $this->request->getPost('stok'), 0), 999999),
            'deskripsi'   => substr(trim($this->request->getPost('deskripsi') ?? ''), 0, 255),
            'foto'        => 'default.jpg',
        ];

        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if (!str_starts_with($file->getMimeType(), 'image/') || $file->getSize() > 2 * 1024 * 1024) {
                return redirect()->to(base_url('stok-ikan'))->with('error', 'Foto harus gambar JPG/PNG/WebP maks 2MB!');
            }
            $newName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/ikan/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $file->move($uploadPath, $newName);
            $saveData['foto'] = $newName;
        }

        $ikanModel->insert($saveData);

        return redirect()->to(base_url('stok-ikan'))->with('success', 'Data stok baru berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $ikanModel = new IkanModel();

        if (!$id) {
            return redirect()->to(base_url('stok-ikan'))->with('error', 'ID Stok tidak valid!');
        }

        $old = $ikanModel->find($id);
        if (!$old) {
            return redirect()->to(base_url('stok-ikan'))->with('error', 'Data stok tidak ditemukan!');
        }

        $updateData = [
            'nama_ikan'   => substr(trim($this->request->getPost('nama_ikan') ?? ''), 0, 100),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'harga_beli'  => min(max((float) preg_replace('/\D/', '', (string) $this->request->getPost('harga_beli')), 0), 999999999),
            'harga_jual'  => min(max((float) preg_replace('/\D/', '', (string) $this->request->getPost('harga_jual')), 0), 999999999),
            'stok'        => min(max((int) $this->request->getPost('stok'), 0), 999999),
            'deskripsi'   => substr(trim($this->request->getPost('deskripsi') ?? ''), 0, 255),
        ];

        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if (!str_starts_with($file->getMimeType(), 'image/') || $file->getSize() > 2 * 1024 * 1024) {
                return redirect()->to(base_url('stok-ikan'))->with('error', 'Foto harus gambar JPG/PNG/WebP maks 2MB!');
            }
            $newName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/ikan/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $file->move($uploadPath, $newName);
            $updateData['foto'] = $newName;
            $oldFoto = $old['foto'] ?? '';
            if ($oldFoto && $oldFoto !== 'default.jpg' && file_exists($uploadPath . $oldFoto)) {
                @unlink($uploadPath . $oldFoto);
            }
        }

        $ikanModel->update($id, $updateData);

        return redirect()->to(base_url('stok-ikan'))->with('success', 'Data stok berhasil diperbarui!');
    }

    public function hapus($id = null)
    {
        $ikanModel = new IkanModel();

        $row = $id ? $ikanModel->find($id) : null;
        if ($row) {
            $ikanModel->delete($id);
            $foto = $row['foto'] ?? '';
            if ($foto && $foto !== 'default.jpg' && file_exists(FCPATH . 'uploads/ikan/' . $foto)) {
                @unlink(FCPATH . 'uploads/ikan/' . $foto);
            }
            return redirect()->to(base_url('stok-ikan'))->with('success', 'Data stok berhasil dihapus!');
        }

        return redirect()->to(base_url('stok-ikan'))->with('error', 'Data stok tidak ditemukan!');
    }

    public function simpanKategori()
    {
        $kategoriModel = new KategoriModel();
        $namaKategori  = substr(trim($this->request->getPost('nama_kategori') ?? ''), 0, 50);
        $satuan        = $this->request->getPost('satuan') === 'Pcs' ? 'Pcs' : 'Ekor';

        if (!empty($namaKategori)) {
            $kategoriModel->insert([
                'nama_kategori' => $namaKategori,
                'satuan'        => $satuan,
            ]);
            return redirect()->to(base_url('stok-ikan'))->with('success', 'Kategori baru berhasil ditambahkan!');
        }

        return redirect()->to(base_url('stok-ikan'))->with('error', 'Nama kategori tidak boleh kosong!');
    }
}
