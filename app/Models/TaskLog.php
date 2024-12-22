<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class TaskLog extends Model
{
    use HasUuids;
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'tasks_logs';

    protected $fillable = [
        'task_id',
        'changed_by',
        'user_id',
        'task_priorities_id',
        'task_statuses_id',
        'name',
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

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
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

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
