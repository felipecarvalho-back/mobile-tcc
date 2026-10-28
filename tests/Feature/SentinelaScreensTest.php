<?php

use App\Models\User;
use App\NativeComponents\AppBottomBar;
use Illuminate\Support\Facades\Artisan;
use Native\Mobile\AsyncTask;
use Native\Mobile\Testing\Native;

it('renders the login screen correctly', function () {
    Native::visit('/login')
        ->assertSee('Sentinela')
        ->assertSee('FATEC')
        ->assertSee('Controle de Acesso e Portaria')
        ->assertSee('Código ou Usuário')
        ->assertSee('Acessar Terminal')
        ->assertSee('Centro Paula Souza');
});

it('renders the profile screen correctly', function () {
    Native::visit('/perfil')
        ->assertSee('Perfil do Operador')
        ->assertSee('Operador Guarita')
        ->assertSee('Unidade & Terminal')
        ->assertSee('FATEC • Centro Paula Souza')
        ->assertSee('Encerrar Turno e Sair');
});

it('renders the history screen with filter chips and grouped items', function () {
    Native::visit('/historico')
        ->assertSee('Histórico de Capturas')
        ->assertSee('Hoje')
        ->assertSee('Docentes')
        ->assertSee('Prestadores')
        ->assertSee('Visitantes')
        ->assertSee('Hoje • '.now()->format('d/m/Y'));
});

it('does not re-navigate or animate when tapping active menu tab', function () {
    $bar = new AppBottomBar;
    $bar->active = 'history';

    // Ao invocar a navegação da mesma aba ativa, a ação é cancelada imediatamente
    $bar->goToHistory();

    expect($bar->active)->toBe('history');
});

it('stores the captured plate photo in private storage', function () {
    $source = tempnam(sys_get_temp_dir(), 'cam');
    file_put_contents($source, 'fake-jpeg');

    $storedPath = AppBottomBar::storePlatePhoto($source);

    expect($storedPath)->toStartWith(storage_path('app/private/plates'))
        ->and(file_get_contents($storedPath))->toBe('fake-jpeg');

    unlink($storedPath);
    unlink($source);
});

it('dispatches async task to upload photo without blocking main thread', function () {
    Artisan::call('migrate');
    $fake = AsyncTask::fake();

    User::query()->delete();
    User::create([
        'name' => 'Operador Teste',
        'email' => 'teste@fatec.sp.gov.br',
        'password' => bcrypt('secret'),
        'access_token' => 'header.'.base64_encode(json_encode(['exp' => time() + 3600])).'.signature',
    ]);

    $source = tempnam(sys_get_temp_dir(), 'cam');
    file_put_contents($source, 'fake-jpeg');

    AppBottomBar::handlePhotoTaken($source);

    $fake->assertDispatched();

    unlink($source);
});
