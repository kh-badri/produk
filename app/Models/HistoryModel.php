<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryModel extends Model
{
    protected $table            = 'history_analisis';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    // Kolom yang diizinkan untuk diisi
    protected $allowedFields    = [
        'tanggal_analisis', 
        'accuracy', 
        'total_data', 
        'hasil_analisis', 
        'hasil_evaluasi'
    ];

    // Menggunakan created_at bawaan
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Kita tidak pakai updated_at
    protected $deletedField  = '';
}