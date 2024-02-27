<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $appends = ['title_card'];

    protected $fillable = [
        'image',
        'pattern',
        'item_name',
        'qty',
        'category',
        'type',
        'desc',
    ];

    public function weekly_breakage()
    {
        return $this->hasMany(WeeklyBreakage::class);
    }

    public function loan()
    {
        return $this->hasMany(Loan::class);
    }

    public function getTitleCardAttribute()
    {
        if (strlen($this->item_name) > 28) {
            $result = substr($this->item_name, 0, 28);
            return $result . '...';
        }
        return $this->item_name;
    }
}
