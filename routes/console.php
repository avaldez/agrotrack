<?php

use Illuminate\Support\Facades\Schedule;

// Limpieza de tokens caducados (sessions)
Schedule::command('auth:clear-resets')->daily();
