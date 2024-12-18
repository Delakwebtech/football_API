<?php

use Illuminate\Support\Facades\Schedule;
  
Schedule::command('fetch:stages')->everySixHours($minutes = 0);
