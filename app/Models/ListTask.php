<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'status',
        'submission',
        'grading',
        'description'
    ];
    protected $append = ['format_updated_at'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormatUpdatedAtAttribute()
    {
        Carbon::setLocale('id');
        return Carbon::parse($this->updated_at)->isoFormat('dddd, DD MMMM YYYY | HH:mm');
    }
}
