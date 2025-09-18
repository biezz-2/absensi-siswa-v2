<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Attendance::query()->with(['student.user', 'subject', 'class', 'teacher.user']);

        if (isset($this->filters['date'])) {
            $query->whereDate('date', $this->filters['date']);
        }
        if (isset($this->filters['class_id'])) {
            $query->where('school_class_id', $this->filters['class_id']);
        }
        if (isset($this->filters['student_id'])) {
            $query->where('student_id', $this->filters['student_id']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Student Name',
            'Class',
            'Subject',
            'Status',
            'Teacher',
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->date,
            $attendance->student->user->name,
            $attendance->class->name,
            $attendance->subject->name,
            ucfirst($attendance->status),
            $attendance->teacher->user->name,
        ];
    }
}