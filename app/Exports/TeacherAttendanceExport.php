<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class TeacherAttendanceExport implements FromQuery, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $teacherId = Auth::user()->teacher->id;
        $query = Attendance::query()
            ->where('teacher_id', $teacherId)
            ->with(['student.user', 'subject', 'class']);

        if (isset($this->filters['date'])) {
            $query->whereDate('date', $this->filters['date']);
        }
        if (isset($this->filters['class_id'])) {
            $query->where('school_class_id', $this->filters['class_id']);
        }
        if (isset($this->filters['subject_id'])) {
            $query->where('subject_id', $this->filters['subject_id']);
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
        ];
    }
}