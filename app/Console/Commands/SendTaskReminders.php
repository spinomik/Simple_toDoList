<?php

namespace App\Console\Commands;

use App\Enums\TaskStatusEnum;
use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskDeadlineReminder;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders to users about task deadlines';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $allowedStatuses = [
            TaskStatusEnum::TODO->value,
            TaskStatusEnum::IN_PROGRESS->value
        ];

        $tasks = Task::whereIn('task_statuses_id', $allowedStatuses)
            ->where('completion_date', '<=', now()->addDay())
            ->where('completion_date', '>=', now())
            ->where('notification_sent', false)
            ->get();


        foreach ($tasks as $task) {
            $task->user->notify(new TaskDeadlineReminder($task));
            $task->notification_sent = true;
            $task->save();
            $this->info('Reminder sent for task: ' . $task->name . ' to useremail: ' . $task->user->email);
        }
    }
}
