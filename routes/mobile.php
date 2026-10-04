<?php

use App\NativeComponents\History;
use App\NativeComponents\Login;
use App\NativeComponents\Profile;
use Illuminate\Support\Facades\Route;

Route::native('/', Login::class);
Route::native('/login', Login::class);
Route::native('/historico', History::class);
Route::native('/perfil', Profile::class);
