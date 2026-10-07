<?php

namespace App\Controllers;

use App\Models\CatatanKalenderModel;

class Kalender extends BaseController
{
    public function getNotes()
    {
        $model = new CatatanKalenderModel();
        $notes = $model->findAll();

        $indexed = [];
        foreach ($notes as $n) {
            $indexed[$n['tanggal']] = $n['catatan'];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'notes'  => $indexed
        ]);
    }

    public function saveNote()
    {
        $model   = new CatatanKalenderModel();
        $tanggal = trim($this->request->getPost('tanggal'));
        $catatan = trim($this->request->getPost('catatan'));

        if (empty($tanggal)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Tanggal tidak valid.'
            ]);
        }

        $existing = $model->where('tanggal', $tanggal)->first();
        if (empty($catatan)) {
            // Delete if text cleared
            if ($existing) {
                $model->delete($existing['id_catatan']);
            }
            return $this->response->setJSON([
                'status'  => 'success',
                'action'  => 'deleted',
                'message' => 'Catatan dihapus.'
            ]);
        }

        if ($existing) {
            $model->update($existing['id_catatan'], [
                'catatan'    => $catatan,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $model->insert([
                'tanggal' => $tanggal,
                'catatan' => $catatan
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'action'  => 'saved',
            'message' => 'Catatan tanggal ' . date('d-m-Y', strtotime($tanggal)) . ' berhasil disimpan!'
        ]);
    }

    public function deleteNote()
    {
        $model   = new CatatanKalenderModel();
        $tanggal = trim($this->request->getPost('tanggal'));

        if (!empty($tanggal)) {
            $existing = $model->where('tanggal', $tanggal)->first();
            if ($existing) {
                $model->delete($existing['id_catatan']);
            }
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Catatan berhasil dihapus.'
        ]);
    }
}
