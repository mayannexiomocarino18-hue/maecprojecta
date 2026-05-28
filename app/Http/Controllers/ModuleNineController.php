<?php

namespace App\Http\Controllers;

use App\Models\Student;

use Dompdf\Dompdf;
use Dompdf\Options;


class ModuleNineController extends Controller
{
    public function generatePDF()
    {
        $data = [
        'title' => 'Student Report',
        'date' => now()->format('F j, Y'),
        'students' => \App\Models\Student::with('degree')->get(),
    ];

        $html = view('pdf.report', $data)->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', realpath(base_path('../')));

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="student-report.pdf"');
    }
}
