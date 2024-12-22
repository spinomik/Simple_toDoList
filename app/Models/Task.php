<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;

class Task extends Model
{
    use HasUuids;
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'tasks';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'name',
        'user_id',
        'notification_sent',
        'task_priorities_id',
        'task_statuses_id',
        'completion_date',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['completionDate' => 'datetime',];
    }
    /**
     * return task priority label
     *
     * @return string
     */

    public function getPriorityLabel(): string
    {
        try {
            return TaskPriorityEnum::from($this->task_priorities_id)->label();
        } catch (\ValueError $e) {
            return 'Unknown Priority';
        }
    }

    /**
     * return task status label
     *
     * @return string
     */

    public function getStatusLabel(): string
    {
        try {
            return TaskStatusEnum::from($this->task_statuses_id)->label();
        } catch (\ValueError $e) {
            return 'Unknown Priority';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function taskPriority()
    {
        return $this->belongsTo(TaskPriority::class, 'task_priorities_id');
    }

    public function taskStatus()
    {
        return $this->belongsTo(TaskStatus::class, 'task_statuses_id');
    }

    public function taskLogs()
    {
        return $this->hasMany(TaskLog::class, 'task_id');
    }
}
