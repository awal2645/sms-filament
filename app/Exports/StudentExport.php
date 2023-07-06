<?php

namespace App\Exports;

use App\Invoice;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;


use Maatwebsite\Excel\Concerns\FromQuery;

class StudentExport implements FromQuery
{
    use Exportable;
    public $students;
    public function __construct(Collection  $students)
    {
        return $this->students = $students;
    }

    public function query()
    {
        return Student::wherekey($this->students->pluck('id')->toArray());
    }
}
