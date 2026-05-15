<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('subastas:cerrar')->everyMinute();
Schedule::command('pagos:liberar')->hourly();
