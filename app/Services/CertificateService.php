<?php

namespace App\Services;

use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CertificateService
{
    /**
     * Generate a PDF certificate for a completed enrollment
     *
     * @param Enrollment $enrollment
     * @param bool $saveToStorage Whether to save the PDF to storage
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generateCertificate(Enrollment $enrollment, bool $saveToStorage = false)
    {
        $enrollment->load(['user', 'course.instructor']);
        
        $studentName = $enrollment->user->name;
        $courseName = $enrollment->course->title;
        $completionDate = $enrollment->completed_at 
            ? Carbon::parse($enrollment->completed_at)->format('Y-m-d')
            : Carbon::now()->format('Y-m-d');
        
        $completionDateFormatted = $enrollment->completed_at
            ? Carbon::parse($enrollment->completed_at)->locale('ar')->isoFormat('D MMMM YYYY')
            : Carbon::now()->locale('ar')->isoFormat('D MMMM YYYY');
        
        $instructorName = $enrollment->course->instructor->name ?? null;
        $certificateNumber = $this->generateCertificateNumber($enrollment);
        
        $pdf = Pdf::loadView('certificates.completion', [
            'studentName' => $studentName,
            'courseName' => $courseName,
            'completionDate' => $completionDateFormatted,
            'instructorName' => $instructorName,
            'certificateNumber' => $certificateNumber,
        ]);
        
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption('enable-local-file-access', true);
        
        // Save to storage if requested
        if ($saveToStorage) {
            $filename = $this->getCertificateFilename($enrollment);
            $path = 'certificates/' . $filename;
            Storage::put($path, $pdf->output());
        }
        
        return $pdf;
    }
    
    /**
     * Get the PDF content as string
     *
     * @param Enrollment $enrollment
     * @return string
     */
    public function getCertificateContent(Enrollment $enrollment): string
    {
        $pdf = $this->generateCertificate($enrollment);
        return $pdf->output();
    }
    
    /**
     * Generate a unique certificate number
     *
     * @param Enrollment $enrollment
     * @return string
     */
    protected function generateCertificateNumber(Enrollment $enrollment): string
    {
        // Format: ENR-{enrollment_id}-{timestamp}
        $date = $enrollment->completed_at 
            ? $enrollment->completed_at->format('Ymd')
            : now()->format('Ymd');
        return 'ENR-' . $enrollment->id . '-' . $date;
    }
    
    /**
     * Get the filename for the certificate
     *
     * @param Enrollment $enrollment
     * @return string
     */
    public function getCertificateFilename(Enrollment $enrollment): string
    {
        $enrollment->load(['user', 'course']);
        $studentName = str_replace(' ', '_', $enrollment->user->name);
        $courseSlug = $enrollment->course->slug ?? 'course-' . $enrollment->course_id;
        $date = $enrollment->completed_at 
            ? $enrollment->completed_at->format('Y-m-d')
            : now()->format('Y-m-d');
        
        return "{$studentName}_{$courseSlug}_{$date}.pdf";
    }
}

