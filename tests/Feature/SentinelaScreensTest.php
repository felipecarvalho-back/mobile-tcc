<?php

use Native\Mobile\Testing\Native;

it('renders the login screen correctly', function () {
    Native::visit('/login')
        ->assertSee('Sentinela')
        ->assertSee('FATEC')
        ->assertSee('Controle de Acesso e Portaria')
        ->assertSee('operador.guarita')
        ->assertSee('Acessar Terminal')
        ->assertSee('Centro Paula Souza');
});

it('renders the monitoring screen with cards, metrics and queue', function () {
    Native::visit('/monitoramento')
        ->assertSee('Área da Guarita')
        ->assertSee('Operador Guarita')
        ->assertSee('GDA - 104')
        ->assertSee('Capturar Placa')
        ->assertSee('Passagens hoje')
        ->assertSee('Liberações automáticas')
        ->assertSee('Correções de placa')
        ->assertSee('Fila da Cancela 01')
        ->assertSee('BRA-2819')
        ->assertSee('Aguardando Liberação')
        ->assertSee('Monitoramento');
});

it('renders the camera capture screen with viewfinder and plate guide', function () {
    Native::visit('/capturar')
        ->assertSee('Capturar Placa')
        ->assertSee('Cancela 01 • Entrada Principal')
        ->assertSee('Placa detectada • foco travado')
        ->assertSee('Posicione a placa dentro da moldura')
        ->assertSee('Toque para capturar');
});

it('renders the history screen with filter chips and grouped items', function () {
    Native::visit('/historico')
        ->assertSee('Histórico de Capturas')
        ->assertSee('Hoje')
        ->assertSee('Docentes')
        ->assertSee('Prestadores')
        ->assertSee('Visitantes')
        ->assertSee('Hoje • 21/09/2026')
        ->assertSee('Carlos Silva')
        ->assertSee('Veículo Não Cadastrado');
});
