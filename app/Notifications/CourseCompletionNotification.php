<?php

namespace App\Notifications;

use App\Models\Enrollment;
use App\Services\CertificateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseCompletionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $enrollment;
    protected $certificateService;

    /**
     * Create a new notification instance.
     */
    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
        $this->certificateService = app(CertificateService::class);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $enrollment = $this->enrollment->load(['user', 'course']);
        $course = $enrollment->course;
        $user = $enrollment->user;
        
        // Generate certificate PDF
        $pdf = $this->certificateService->generateCertificate($enrollment);
        $certificateContent = $pdf->output();
        
        $certificateFilename = $this->certificateService->getCertificateFilename($enrollment);
        
        return (new MailMessage)
            ->subject('Certificate of Completion - ' . $course->title)
            ->greeting('Hello ' . $user->name . '!')
            ->line('We would like to congratulate you on completing the course **' . $course->title . '**.')
            ->line('You have shown great dedication and commitment by completing all the lessons of the course.')
            ->line('We wish you the best in your educational journey!')
            ->action('View Other Courses', route('front.courses.index'))
            ->line('Thank you for using our educational platform.')
            ->attachData($certificateContent, $certificateFilename, [
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'enrollment_id' => $this->enrollment->id,
            'course_id' => $this->enrollment->course_id,
            'course_title' => $this->enrollment->course->title,
        ];
    }
}

