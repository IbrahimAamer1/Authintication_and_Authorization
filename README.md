

## 📅 Task Scheduling Branch

This branch is dedicated to implementing **Laravel Task Scheduling** features for the e-learning platform.

### What Was Implemented

#### Course Completion Certificate System
A complete automated system that sends congratulation emails with PDF certificates when students complete courses.

**Features:**
- ✅ Automatic email notifications with PDF certificate attachment
- ✅ Professional certificate design with student name, course name, and completion date
- ✅ Prevents duplicate emails using `congratulation_sent_at` timestamp
- ✅ Scheduled task runs hourly to check for completed enrollments
- ✅ Uses Laravel Task Scheduling with cron jobs

**Components Added:**

1. **Migration**
   - Added `congratulation_sent_at` column to `enrollments` table
   - File: `database/migrations/2026_01_04_021657_add_congratulation_sent_at_to_enrollments_table.php`

2. **PDF Generation**
   - Installed `barryvdh/laravel-dompdf` package
   - Created `CertificateService` for PDF generation
   - File: `app/Services/CertificateService.php`
   - Certificate template: `resources/views/certificates/completion.blade.php`

3. **Email Notification**
   - Created `CourseCompletionNotification` class
   - Sends email with PDF certificate attached
   - File: `app/Notifications/CourseCompletionNotification.php`

4. **Scheduled Command**
   - Created `SendCourseCompletionCongrats` command
   - Finds completed enrollments and sends congratulations
   - File: `app/Console/Commands/SendCourseCompletionCongrats.php`

5. **Task Scheduling**
   - Added scheduled task in `app/Console/Kernel.php`
   - Runs hourly: `php artisan courses:send-completion-congrats`

6. **Model Updates**
   - Updated `Enrollment` model to cast `congratulation_sent_at` as datetime

### How to Use

1. **Run Migration:**
   ```bash
   php artisan migrate
   ```

2. **Test the Command:**
   ```bash
   php artisan courses:send-completion-congrats
   ```

3. **Setup Cron Job (Production):**
   Add this to your server's crontab:
   ```bash
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

### Technical Details

- **Queue System:** Uses Laravel Queue (requires `QUEUE_CONNECTION=database` or `sync`)
- **PDF Library:** barryvdh/laravel-dompdf v3.1.1
- **Scheduling:** Laravel Task Scheduler with hourly execution
- **Email Attachment:** PDF certificate attached to congratulation email
