# Back-end Challenge - Dictionary by Lucas Macena

## Introdução

Este é um teste para vaga de desenvolvedor back-end.

# Tecnologias Utilizadas no Projeto

Este projeto utiliza as seguintes tecnologias:

- **PHP**: Linguagem de programação utilizada no backend do projeto.
- **Laravel**: Framework PHP que facilita o desenvolvimento de aplicações web robustas e escaláveis.
- **Docker**: Plataforma para desenvolver, enviar e executar aplicativos em contêineres, garantindo consistência entre ambientes.
- **MySQL**: Sistema de gerenciamento de banco de dados relacional utilizado para armazenar os dados do projeto.
- **Telescope**: Biblioteca Laravel que oferece uma visão detalhada da aplicação, monitorando requisições, exceções, logs e muito mais.
- **Scribe**: Biblioteca que facilita a documentação da API, gerando automaticamente uma documentação interativa baseada nas rotas da aplicação.
- **JWT (JSON Web Token)**: Biblioteca para autenticação baseada em tokens, utilizada para criar e verificar tokens de segurança em APIs.

# Guia de Instalação

Este guia explica como configurar o ambiente de desenvolvimento para o projeto `desafio_backend` utilizando Docker.

## Pré-requisitos

1. **Instalar o Docker**:
   - A primeira etapa é instalar o Docker em sua máquina. Siga o passo a passo fornecido na documentação oficial:
     - [Documentação do Docker](https://docs.docker.com/get-started/get-docker/)

2. **Instalar o Docker Compose**:
   - O Docker Compose é necessário para orquestrar os containers. Caso ainda não tenha o Docker Compose instalado, você pode segui-lo na documentação oficial: [Instalar Docker Compose](https://docs.docker.com/compose/install/).

## Passos para a Configuração

### 1. Clonar o Repositório

Clone o repositório do projeto:

```bash
git clone https://github.com/Lucas-MSF/desafio_backend.git
```

### 2. Configurar o Arquivo `.env`

Após clonar o repositório, copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

Agora, edite o arquivo `.env` e substitua as configurações de banco de dados e Redis com os valores abaixo:

```dotenv
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 3. Subir os Containers Docker

Entre na pasta do projeto e execute o seguinte comando para baixar e iniciar os containers da aplicação:

```bash
docker compose up -d
```

### 4. Acessar o Terminal da Aplicação

Agora, entre no terminal do container da aplicação com o comando:

```bash
docker compose exec app bash
```

### 5. Instalar as Dependências

Dentro do terminal do container, execute o comando abaixo para instalar as dependências do Laravel:

```bash
composer install
```

### 6. Configurações Finais

Com as dependências instaladas, execute os seguintes comandos do Artisan para finalizar a configuração do projeto:

```bash
php artisan key:generate
php artisan jwt:secret
php artisan storage:link
```

### 7. Gerar a Documentação da API

Para gerar a documentação da API, basta rodar o comando:

```bash
php artisan scribe:generate
```

>  This is a challenge by [Coodesh](https://coodesh.com/)
