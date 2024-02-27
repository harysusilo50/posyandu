<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyBreakage extends Model
{
    use HasFactory;

    protected $appends = ['format_date'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function getFormatDateAttribute()
    {
        Carbon::setLocale('id');
        $result = Carbon::parse($this->date)->isoFormat('dddd, DD MMMM YYYY');
        return $result;
    }
}
