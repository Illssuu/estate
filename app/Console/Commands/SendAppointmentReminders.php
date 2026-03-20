<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';
    protected $description = 'Send email reminders for appointments in 1 hour';

    public function handle()
    {
        $now = Carbon::now();
        $oneHourLater = $now->copy()->addHour();
        
        $this->info('Checking appointments at: ' . $now->format('Y-m-d H:i:s'));
        
        // Находим записи, которые будут через час (±5 минут)
        $appointments = Appointment::where('status', 'active')
            ->where('reminder_sent', false)
            ->where('date', $now->format('Y-m-d'))
            ->whereBetween('time', [
                $oneHourLater->format('H:i:s'),
                $oneHourLater->copy()->addMinutes(5)->format('H:i:s')
            ])
            ->with(['user', 'flat'])
            ->get();
        
        $this->info('Found ' . $appointments->count() . ' appointments to remind');
        
        $sentCount = 0;
        $errorCount = 0;
        
        foreach ($appointments as $appointment) {
            try {
                if (!$appointment->user || !$appointment->user->email) {
                    $this->error("User or email missing for appointment ID: {$appointment->id}");
                    $errorCount++;
                    continue;
                }
                
                Mail::to($appointment->user->email)->send(new AppointmentReminder($appointment));
                
                $appointment->update([
                    'reminder_sent' => true,
                    'reminder_sent_at' => Carbon::now()
                ]);
                
                $sentCount++;
                $this->info("✓ Reminder sent to: {$appointment->user->email} (Appointment ID: {$appointment->id})");
                
            } catch (\Exception $e) {
                $errorCount++;
                $this->error("✗ Failed to send to {$appointment->user->email}: {$e->getMessage()}");
            }
        }
        
        $this->info("Completed. Sent: {$sentCount}, Errors: {$errorCount}");
        
        return 0;
    }
}