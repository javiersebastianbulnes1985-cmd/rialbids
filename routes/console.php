<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('subastas:cerrar')->everyMinute();
Schedule::command('vendors:recordatorio')->hourly();
Schedule::command('pagos:liberar')->hourly();
Schedule::command('envios:alertar')->daily();
Schedule::command('emails:marketing', ['semanal'])->weeklyOn(1, '09:00');
Schedule::command('emails:marketing', ['finaliza'])->dailyAt('10:00');
