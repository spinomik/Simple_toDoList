<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('tasks:send-reminders')->everyFiveMinutes();
