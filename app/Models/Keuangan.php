<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $appends = ['format_nominal', 'format_tanggal'];

    public function getFormatNominalAttribute()
    {
        return number_format($this->amount, 0, ',', '.');
    }

    public function getFormatTanggalAttribute()
    {
        return \Carbon\Carbon::parse($this->tanggal)->format('d M Y H:i:s');
    }
}
