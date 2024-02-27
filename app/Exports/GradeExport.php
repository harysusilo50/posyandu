<?php

namespace App\Exports;

use App\Models\ListTask;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GradeExport implements FromCollection, WithHeadings, WithMapping
{
    protected $task_id;
    protected $counter = 0;

    public function __construct($task_id)
    {
        $this->task_id = $task_id;
    }

    public function collection()
    {
        $data = User::leftJoin('list_tasks as lists', function ($join) {
            $join->on('users.id', '=', 'lists.user_id')
                ->where('lists.task_id', $this->task_id);
        })->where('role', 'user')
            ->select(
                'users.nim',
                'users.name',
                'lists.status',
                'lists.grading',
                'lists.created_at',
            )
            ->get();
        return $data;
    }

    public function headings(): array
    {
        return ['No', 'NIM', 'Nama', 'Status', 'Nilai', 'Tanggal'];
    }
    public function map($data): array
    {
        return [
            ++$this->counter,
            "'" . $data->nim,
            $data->name,
            $data->status ?? '-',
            $data->grading ?? '-',
            $data->created_at ?? '-'
        ];
    }
}
