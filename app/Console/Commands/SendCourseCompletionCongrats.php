<?php

namespace App\Console\Commands;

use App\Models\Enrollment;
use App\Notifications\CourseCompletionNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendCourseCompletionCongrats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:send-completion-congrats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send congratulation emails with certificates to students who completed courses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to send course completion congratulations...');
        
        // Find enrollments that are completed but haven't received congratulations yet
        $enrollments = Enrollment::where('status', 'completed')
            ->whereNotNull('completed_at')
            ->whereNull('congratulation_sent_at')
            ->with(['user', 'course'])
            ->get();
        
        if ($enrollments->isEmpty()) {
            $this->info('No enrollments found that need congratulations.');
            return Command::SUCCESS;
        }
        
        $this->info("Found {$enrollments->count()} enrollment(s) to process.");
        
        $successCount = 0;
        $failureCount = 0;
        
        foreach ($enrollments as $enrollment) {
            try {
                // Check if user exists and has email
                if (!$enrollment->user || !$enrollment->user->email) {
                    $this->warn("Skipping enrollment #{$enrollment->id}: User or email not found.");
                    $failureCount++;
                    continue;
                }
                
                // Send notification
                $enrollment->user->notify(new CourseCompletionNotification($enrollment));
                
                // Update congratulation_sent_at
                $enrollment->update([
                    'congratulation_sent_at' => now(),
                ]);
                
                $successCount++;
                $this->info("✓ Sent congratulations to {$enrollment->user->name} for course: {$enrollment->course->title}");
                
            } catch (\Exception $e) {
                $failureCount++;
                $this->error("✗ Failed to send congratulations for enrollment #{$enrollment->id}: {$e->getMessage()}");
                Log::error('Failed to send course completion congratulations', [
                    'enrollment_id' => $enrollment->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }
        
        $this->info("\nCompleted!");
        $this->info("Successfully sent: {$successCount}");
        $this->info("Failed: {$failureCount}");
        
        return Command::SUCCESS;
    }
}
