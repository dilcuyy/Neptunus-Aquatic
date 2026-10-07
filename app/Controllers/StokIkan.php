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

        foreach ($fishList as &$fish) {
            $stok = (int) $fish['stok'];
            if ($stok > 50) {
                $fish['status_stok'] = 'Aman';
                $fish['badge'] = 'bg-success';
            } elseif ($stok > 20) {
                $fish['status_stok'] = 'Sedikit';
                $fish['badge'] = 'bg-warning';
            } else {
                $fish['status_stok'] = 'Kritis';
                $fish['badge'] = 'bg-danger';
            }
        }

        $data = [
            'title'        => 'Stok Ikan',
            'description'  => 'Manajemen & kelola data stok ikan hias secara lengkap (CRUD).',
            'heading_icon' => 'pe-7s-box2',
            'activeMenu'   => 'stok_ikan',
            'fish_list'    => $fishList,
            'kategori_list'=> $kategoriList
        ];

        return view('stok_ikan/index', $data);
    }

    public function simpan()
    {
        $ikanModel = new IkanModel();

        $saveData = [
            'nama_ikan'   => $this->request->getPost('nama_ikan'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'harga_beli'  => $this->request->getPost('harga_beli'),
            'harga_jual'  => $this->request->getPost('harga_jual'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
        ];

        $ikanModel->insert($saveData);

        return redirect()->to(base_url('stok-ikan'))->with('success', 'Data ikan baru berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $ikanModel = new IkanModel();

        if (!$id) {
            return redirect()->to(base_url('stok-ikan'))->with('error', 'ID Ikan tidak valid!');
        }

        $updateData = [
            'nama_ikan'   => $this->request->getPost('nama_ikan'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'harga_beli'  => $this->request->getPost('harga_beli'),
            'harga_jual'  => $this->request->getPost('harga_jual'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
        ];

        $ikanModel->update($id, $updateData);

        return redirect()->to(base_url('stok-ikan'))->with('success', 'Data ikan berhasil diperbarui!');
    }

    public function hapus($id = null)
    {
        $ikanModel = new IkanModel();

        if ($id && $ikanModel->find($id)) {
            $ikanModel->delete($id);
            return redirect()->to(base_url('stok-ikan'))->with('success', 'Data ikan berhasil dihapus!');
        }

        return redirect()->to(base_url('stok-ikan'))->with('error', 'Data ikan tidak ditemukan!');
    }

    public function simpanKategori()
    {
        $kategoriModel = new KategoriModel();
        $namaKategori  = trim($this->request->getPost('nama_kategori'));

        if (!empty($namaKategori)) {
            $kategoriModel->insert([
                'nama_kategori' => $namaKategori
            ]);
            return redirect()->to(base_url('stok-ikan'))->with('success', 'Kategori ikan baru berhasil ditambahkan!');
        }

        return redirect()->to(base_url('stok-ikan'))->with('error', 'Nama kategori tidak boleh kosong!');
    }
}
