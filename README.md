# Sentinela FATEC • Aplicativo Mobile (TCC)

> **Trabalho de Conclusão de Curso (TCC)**  
> **Tema:** Sistema Móvel de Captura Fotográfica e Integração com API Externa para Controle de Acesso e Portaria  
> **Instituição:** Centro Paula Souza • Faculdade de Tecnologia (FATEC)

---

## 🎯 Objetivo do Trabalho

O objetivo deste projeto de TCC é desenvolver uma solução móvel focada no **módulo de câmera nativa**, permitindo que o operador da guarita/portaria capture fotos de placas e veículos em tempo real e as **envie para uma API externa** responsável pelo processamento, reconhecimento de caracteres (OCR) e regras de autorização de acesso.

O aplicativo atua como o cliente de borda (*edge client*) do sistema:
1. **Captura Fotográfica**: Aciona a câmera nativa com alta performance diretamente pelo aplicativo.
2. **Buffer Local**: Salva temporariamente a foto no armazenamento local seguro do dispositivo (`storage/app/private/plates/`).
3. **Envio para API Externa**: Despacha a imagem capturada e os metadados do terminal para os endpoints da API backend externa de reconhecimento e validação de acessos.
4. **Consulta e Histórico**: Recebe o retorno da validação e exibe o histórico das passagens registradas para consulta do operador.

---

## 📱 Funcionalidades do Aplicativo

- **Disparo e Captura da Câmera**: Integração direta com a câmera do dispositivo via plugin nativo (`nativephp/mobile-camera`), com solicitação automática de permissões em tempo de execução.
- **Transmissão para API Externa**: Preparação e despacho do arquivo de imagem capturado para o serviço externo de processamento.
- **Histórico de Passagens**: Consulta de registros de veículos liberados e pendentes com filtros por categoria (Docentes, Prestadores, Visitantes).
- **Perfil e Turno do Operador**: Identificação do operador logado, terminal ativo e encerramento de turno.
- **Interface 100% Nativa (SuperNative)**: Construído com **Laravel 13** e **NativePHP Mobile v4**, renderizado diretamente em componentes nativos (**Jetpack Compose** no Android e **SwiftUI** no iOS), sem o uso de WebViews.

---

## 🛠️ Tecnologias Utilizadas

- **[PHP 8.4+](https://www.php.net/)**
- **[Laravel 13](https://laravel.com/)**
- **[NativePHP Mobile v4](https://nativephp.com/docs/mobile/4)** (SuperNative + EDGE Components)
- **[nativephp/mobile-camera](https://plugins.nativephp.com)** (Plugin nativo para captura de câmera e gestão de permissões)
- **[nativephp/mobile-ui](https://plugins.nativephp.com)** (Design system nativo e tokens de interface)
- **[Pest PHP](https://pestphp.com/)** (Suíte de testes de interface e comportamento nativo com `Native::test()`)
- **[Laravel Pint](https://laravel.com/docs/pint)** (Padronização e formatação de código)

---

## 📂 Estrutura do Projeto

```text
├── app/
│   ├── NativeComponents/       # Componentes e telas nativas (EDGE)
│   │   ├── AppBottomBar.php    # Barra de navegação inferior e acionamento da câmera
│   │   ├── History.php         # Tela de histórico de passagens
│   │   ├── Login.php           # Tela de autenticação do operador
│   │   ├── MercosulPlate.php   # Componente visual da placa Mercosul
│   │   ├── Profile.php         # Tela de perfil e dados do terminal/turno
│   │   └── VehicleCard.php     # Card de exibição de veículo registrado
│   ├── Icons/                  # Enums tipados para ícones de sistema (Android / iOS)
│   └── Providers/
│       └── NativeServiceProvider.php # Registro dos plugins nativos (Câmera, Browser, UI)
├── config/
│   ├── native-ui.php           # Configuração de tema institucional (FATEC) e fontes
│   └── nativephp.php          # Configuração de permissões de hardware (Câmera / Info.plist)
├── resources/
│   └── views/native/           # Telas Blade compostas com elementos nativos EDGE
├── routes/
│   └── mobile.php              # Roteamento exclusivo do aplicativo móvel
└── tests/Feature/
    └── SentinelaScreensTest.php # Testes automatizados das telas e fluxo de salvamento
```

---

## 🚀 Como Executar o Projeto

### Pré-requisitos

1. **PHP 8.4+** com extensões ativas: `sqlite3`, `curl`, `mbstring`.
2. **Composer** instalado.
3. **Android Studio** com SDK configurado e emulador Android (ou smartphone físico com depuração USB).

### Instalação

1. Clone o repositório e instale as dependências:
   ```bash
   composer install
   ```

2. Configure o arquivo de ambiente:
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

3. Instale o shell nativo do NativePHP:
   ```bash
   php artisan native:install
   ```

### Execução no Dispositivo / Emulador

> [!NOTE]
> Os comandos do NativePHP devem ser executados no seu terminal para compilar e inicializar o emulador ou aparelho físico.

- **Compilar e rodar no Android**:
  ```bash
  php artisan native:run android
  ```

- **Modo de desenvolvimento contínuo (Hot Reload)**:
  ```bash
  php artisan native:watch
  ```

- **Acompanhar logs do aplicativo e eventos em tempo real**:
  ```bash
  php artisan native:tail
  ```

---

## 🧪 Testes Automatizados

O projeto conta com suíte de testes com **Pest PHP** e suporte nativo de componentes (`Native::test()` e `Native::visit()`):

```bash
php artisan test
```

Para validar a formatação do código:

```bash
vendor/bin/pint --format agent
```

---

## 📄 Informações do TCC

Projeto desenvolvido como **Trabalho de Conclusão de Curso (TCC)** para os cursos de tecnologia do **Centro Paula Souza • Faculdade de Tecnologia (FATEC)**.
