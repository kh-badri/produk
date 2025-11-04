<?php

namespace App\Models;

use CodeIgniter\Model;

class DatasetModel extends Model
{
    /**
     * Nama tabel yang digunakan oleh model ini.
     * Sesuaikan dengan nama tabel di database Anda.
     */
    protected $table            = 'dataset_produk';
    
    /**
     * Primary key dari tabel.
     */
    protected $primaryKey       = 'id';
    
    /**
     * Apakah menggunakan auto-increment.
     */
    protected $useAutoIncrement = true;
    
    /**
     * Kolom yang diizinkan untuk diisi (mass assignment).
     * Ini HARUS Sesuai dengan 7 kolom data Anda.
     */
    protected $allowedFields    = [
        'waktu_penjualan',
        'nama_produk',
        'kategori_produk',
        'harga_produk_rp',
        'jumlah_terjual_unit',
        'status_promosi',
        'terjadi_penurunan'
    ];

    // Mengaktifkan timestamp (created_at, updated_at)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Fungsi helper untuk mengosongkan tabel (TRUNCATE).
     */
    public function emptyTable()
    {
        // TRUNCATE lebih cepat dan me-reset auto_increment
        return $this->db->table($this->table)->truncate();
    }
}
