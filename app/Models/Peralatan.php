<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
    use HasFactory;


    protected $append = ['format_tgl_pembelian'];

    public function getFormatTglPembelianAttribute()
    {
        return Carbon::parse($this->attributes['tgl_pembelian'])->isoFormat('dddd, D MMMM Y');
    }
}
