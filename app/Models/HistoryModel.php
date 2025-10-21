<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryModel extends Model
{
    protected $table            = 'history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'durasi_layar',
        'durasi_sosmed',
        'durasi_tidur',
        'k',
        'hasil_klasifikasi'
    ];

    // Mengaktifkan auto-timestamps
    protected $useTimestamps = true;
}
