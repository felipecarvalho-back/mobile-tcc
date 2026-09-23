<?php

use App\NativeComponents\CameraCapture;
use App\NativeComponents\History;
use App\NativeComponents\Home;
use App\NativeComponents\Login;
use App\NativeComponents\Monitoring;
use App\NativeComponents\Profile;
use Illuminate\Support\Facades\Route;

Route::native('/', Login::class);
Route::native('/starter', Home::class);
Route::native('/login', Login::class);
Route::native('/monitoramento', Monitoring::class);
Route::native('/capturar', CameraCapture::class);
Route::native('/historico', History::class);
Route::native('/perfil', Profile::class);
