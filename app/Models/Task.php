<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function listTask()
    {
        return $this->hasMany(listTask::class);
    }

    public function getFormatCreatedAtAttribute()
    {
        Carbon::setLocale('id');
        return Carbon::parse($this->created_at)->isoFormat('dddd, DD MMMM YYYY | HH:mm');
    }

    public function getDeadlineTugasFormatAttribute()
    {
        Carbon::setLocale('id');
        return Carbon::parse($this->deadline_tugas)->isoFormat('dddd, DD MMMM YYYY | HH:mm');
    }

    public function getSisaWaktuTugasAttribute()
    {
        $now = time();
        $deadline = strtotime($this->deadline_tugas);
        $time_format = $deadline - $now;
        return $this->convertTime($time_format);
    }

    private function convertTime($deadline)
    {
        $jumlahHari = floor($deadline / (60 * 60 * 24));
        $sisaDetik = $deadline % (60 * 60 * 24);
        $jumlahJam = floor($sisaDetik / (60 * 60));
        $sisaDetik = $sisaDetik % (60 * 60);
        $jumlahMenit = floor($sisaDetik / 60);

        $jumlahHari = $jumlahHari < 0 ? 0 : $jumlahHari;
        $jumlahJam = $jumlahJam < 0 ? 0 : $jumlahJam;
        $jumlahMenit = $jumlahMenit < 0 ? 0 : $jumlahMenit;

        return $jumlahHari . ' Hari ' . $jumlahJam . ' Jam ' . $jumlahMenit . ' Menit ';
    }
}
