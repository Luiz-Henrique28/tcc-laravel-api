# TCC API - Laravel 13

Esta é a API RESTful desenvolvida em Laravel 13 para fins de comparação acadêmica de desempenho (TCC).

## Tecnologias
- PHP 8.4
- Laravel 13
- PostgreSQL 14
- Nginx 1.25
- Docker & Docker Compose
- PgBouncer (Connection Pooling)

## Como rodar com Docker

1. Clone o repositório.
2. Copie o arquivo de ambiente padrão:
   ```bash
   cp .env.example .env
   ```
3. Suba os contêineres em segundo plano:
   ```bash
   docker compose up -d
   ```
4. Instale as dependências e popule o banco de dados:
   ```bash
   docker compose exec app composer install
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan migrate --force
   docker compose exec app php artisan db:seed
   ```

A API estará disponível em `http://127.0.0.1:8001`.
Para acessar via Postman, importe a coleção `postman_collection.json` inclusa na raiz.
