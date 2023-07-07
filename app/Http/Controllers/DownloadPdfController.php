<?php

namespace App\Http\Controllers;

use App\Models\Student;
use PDF;
class DownloadPdfController extends Controller
{
    public function download($record)
    {
       
        $users = Student::find($record);

        $data = [
            'title' => 'Welcome to Laravel Filament',
            'date' => date('m/d/Y'),
            'users' => $users,
        ];

        $pdf = PDF::loadView('pdf', $data);

        return $pdf->download('awal.pdf');
    }
}
