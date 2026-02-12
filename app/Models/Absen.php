<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table = 'Absen';

    protected $fillable = [
        'user_id',
        'nama',
        'nis',
        'jurusan',
        'status',
        'kelas',
        'tanggal_absen',
        // 'foto',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

  
}
