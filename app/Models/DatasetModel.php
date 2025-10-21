<?php

namespace App\Models;

use CodeIgniter\Model;

class DatasetModel extends Model
{
    protected $table            = 'dataset';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'durasi_layar',
        'durasi_sosmed',
        'durasi_tidur',
        'resiko_depresi'
    ];

    // Mengaktifkan auto-timestamps
    protected $useTimestamps = true;
}
