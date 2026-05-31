<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ModuleNineController extends Controller
{
    public function generatePDF(): Response
    {
        $data = [
            'title' => 'Student Report',
            'date' => now()->format('F j, Y'),
            'students' => Student::with('degree')->orderBy('id')->get(),
        ];

        return Pdf::loadView('pdf.report', $data)
            ->setPaper('a4', 'portrait')
            ->stream('student-report.pdf');
    }
}
