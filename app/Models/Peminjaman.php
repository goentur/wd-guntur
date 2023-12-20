<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function mobil()
    {
        return $this->belongsTo(Mobil::class)->with('merek');
    }
    public function user()
    {
        return $this->belongsTo(User::class)->with('userDetail');
    }
}
