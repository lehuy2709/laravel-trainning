<?php

namespace App\Console\Commands;

use App\Mail\AutoSendMail;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AutoMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'automail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $students = Student::with('subjects')->get();
        $countSubject = Subject::count('id');

        foreach ($students as $student) {
            if ($student->subjects->count() ==  $countSubject) {
                for ($i = 0; $i <  $countSubject; $i++) {
                    if ($student->subjects[$i]->pivot->point === null) {
                        break;
                    } elseif ($i ==  $countSubject - 1) {
                        $avg = $student->subjects->avg('pivot.point');
                        if ($avg < 5) {
                            $mailable = new AutoSendMail();
                            Mail::to($student->email)->queue($mailable);
                        }
                    }
                }
            }
        }
    }
}
