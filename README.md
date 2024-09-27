# Sistema de cadastro de evento e participação

O sistema oferece funcionalidades de divulgação de eventos, permitindo que a empresa promova o evento e os clientes se inscrevam, enquanto as vagas vão sendo preenchidas. Além disso, o organizador pode monitorar a participação e acessar a lista de inscritos.

## Requisitos do Sistema

Para operar a API do sistema, são necessários os seguintes requisitos mínimos na sua máquina: PHP, Composer, Docker. O PHP e o Composer são essenciais para executar o Laravel, que contém a API principal do sistema. O Docker é utilizado para virtualizar o ambiente no qual a API é executada. Estes componentes garantem a funcionalidade e o desempenho ideais do nosso sistema de forma integrada e eficiente.

## Arquitetura do Sistema

O sistema utiliza as seguintes linguagens:

- PHP

Banco de dados:

- MySQL

Frameworks:

- Laravel

Arquitetura da API:

- MVC
- RESTful

Além disso, faz uso de:

- Docker

## Como Iniciar o Sistema

### Passo 1: Download dos Arquivos

Clone o repositório:

```bash
git clone https://github.com/andre-albuquerque01/Events-App.git
```

### Passo 2: Configuração do Back-end

Entre na pasta Api:

```bash
cd /Api
```

Inicialize os pacotes do Laravel:

```php
composer install
```

Crie um arquivo `.env` na raiz do seu projeto e configure as variáveis de ambiente conforme necessário.
Execute `php artisan config:cache` para aplicar as configurações do arquivo `.env`.

Inicie o servidor da API:

```bash
sudo ./vendor/bin/sail up
```

Para desativar o servidor da API:

```bash
sudo ./vendor/bin/sail down
```

### Passo 3: Acesso a API

Abra o postman ou algum app semelhante ao postman e acesse `http://localhost` para utilizar o serviço.

### Passo 4: Configuração do Front-end

Entre na pasta e baixe as dependências do Node.js:

```bash
npm i
```

Inicie o servidor do Next.js:

```bash
npm run dev
```

### Passo 5: Acesso a interface

Abra o navegador e acesse `http://localhost:3000` para utilizar o serviço.
