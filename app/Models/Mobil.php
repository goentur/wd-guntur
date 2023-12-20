<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function merek()
    {
        return $this->belongsTo(Merek::class);
    }
    public function peminjamanBelum()
    {
        return $this->hasMany(Peminjaman::class)->where('status', 'b')->whereDate('tanggal_akhir', '>=', date('Y-m-d'));
    }
}
