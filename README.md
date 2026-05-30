<h1 align="center">TCC — API de Catálogo de Produtos (Laravel 13)</h1>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.4">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 13">
  <img src="https://img.shields.io/badge/PostgreSQL-14-4169E1?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL 14">
  <img src="https://img.shields.io/badge/Docker-Compose-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker Compose">
  <img src="https://img.shields.io/badge/Nginx-1.25-009639?style=for-the-badge&logo=nginx&logoColor=white" alt="Nginx 1.25">
  <img src="https://img.shields.io/badge/PgBouncer-Connection_Pool-336791?style=for-the-badge" alt="PgBouncer">
</p>

---

## Contexto

Este repositório contém a implementação em **Laravel 13** de uma API RESTful de Catálogo de Produtos desenvolvida como parte de um Trabalho de Conclusão de Curso (TCC).

O objetivo do TCC é realizar uma **análise comparativa de desempenho** entre os frameworks **Laravel** e **Django** sob diferentes cenários de carga, com e sem o uso de *Connection Pooling* (PgBouncer). Ambas as APIs foram desenvolvidas de forma rigorosamente equivalente — com os mesmos endpoints, modelagem de dados, estrutura de resposta JSON e volume de dados — para garantir uma comparação justa e metodologicamente válida.

As métricas avaliadas nos testes são: **Latência**, **Requisições por Segundo (RPS)**, **Consumo de CPU**, **Consumo de Memória** e **Taxa de Erros**.

---

## Pré-requisitos

- Docker Desktop com backend WSL2 habilitado
- Git
- Ubuntu via WSL2 (para execução dos testes de carga)

> ⚠️ **Usuários Windows:** todos os comandos abaixo devem ser executados dentro do terminal do **Ubuntu (WSL2)**, e não pelo PowerShell ou CMD.

---

## Como Rodar o Projeto

### 1. Clone o repositório
```bash
git clone https://github.com/SEU_USUARIO/tcc-laravel-api.git
cd tcc-laravel-api
```

### 2. Configure as variáveis de ambiente
```bash
cp .env.example .env
```

### 3. Suba os contêineres
```bash
docker compose up -d
```

### 4. Instale as dependências e configure a aplicação
```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
```

### 5. Rode as migrações e popule o banco de dados
```bash
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed
```

A API estará disponível em `http://127.0.0.1:8001`.

> 💡 **Seed:** O seeder popula o banco com **20 categorias** e **1.000 produtos** gerados com semente de aleatoriedade fixa (`srand(42)`), garantindo dados idênticos aos do repositório Django para fins de comparação.

---

## Testando a API

### 1. Coleção do Postman

Para testar os endpoints manualmente, importe a coleção inclusa na raiz do projeto:

1. Abra o **Postman**.
2. Clique em **Import** e selecione o arquivo `postman_collection.json`.
3. A coleção já inclui as variáveis `{{base_url}}` (apontando para `http://127.0.0.1:8001`) e `{{token}}` para facilitar os testes autenticados.

> 💡 **Fluxo recomendado:** Execute primeiro o *Register* ou o *Login* para obter o token de acesso. Copie o token retornado e cole na variável `{{token}}` da coleção. As rotas de escrita estarão liberadas.

### 2. Teste rápido via cURL

```bash
# Listar produtos (rota pública)
curl -s http://127.0.0.1:8001/api/products | python3 -m json.tool

# Registrar um usuário
curl -s -X POST http://127.0.0.1:8001/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Henrique","email":"teste@tcc.com","password":"senha123"}' \
  | python3 -m json.tool
```

---

## Endpoints

### Autenticação

| Método | Rota | Auth? | Descrição |
|--------|------|-------|-----------|
| `POST` | `/api/auth/register` | ❌ | Registrar novo usuário e obter token |
| `POST` | `/api/auth/login` | ❌ | Autenticar e obter token |
| `POST` | `/api/auth/logout` | ✅ Bearer | Invalidar o token atual |

### Categorias

| Método | Rota | Auth? | Descrição |
|--------|------|-------|-----------|
| `GET` | `/api/categories` | ❌ | Listar todas as categorias |
| `GET` | `/api/categories/{id}` | ❌ | Exibir uma categoria |
| `POST` | `/api/categories` | ✅ Bearer | Criar nova categoria |
| `PUT` | `/api/categories/{id}` | ✅ Bearer | Atualizar uma categoria |
| `DELETE` | `/api/categories/{id}` | ✅ Bearer | Remover uma categoria |

### Produtos

| Método | Rota | Auth? | Descrição |
|--------|------|-------|-----------|
| `GET` | `/api/products` | ❌ | Listar produtos (paginado, 20/pág, ordenado por ID desc) |
| `GET` | `/api/products?category={id}` | ❌ | Filtrar produtos por categoria |
| `GET` | `/api/products/{id}` | ❌ | Exibir um produto |
| `POST` | `/api/products` | ✅ Bearer | Criar novo produto |
| `PUT` | `/api/products/{id}` | ✅ Bearer | Atualizar um produto |
| `DELETE` | `/api/products/{id}` | ✅ Bearer | Remover um produto |

### Formato de Resposta (JSON Padronizado)

**Listagem de produtos:**
```json
{
  "data": [ { "id": 1000, "nome": "...", "preco": "...", "estoque": 0, "categoria": { "id": 1, "nome": "..." }, "criado_em": "...", "atualizado_em": "..." } ],
  "links": { "first": "...", "last": "...", "prev": null, "next": "..." },
  "meta": { "current_page": 1, "last_page": 50, "per_page": 20, "total": 1000 }
}
```

---

## Modelagem de Dados

A API expõe dois recursos principais ligados por chave estrangeira:

**`categories`**

| Campo | Tipo | Detalhe |
|-------|------|---------|
| `id` | `BIGINT PK` | Auto-incremento |
| `nome` | `VARCHAR(255)` | — |
| `descricao` | `TEXT` | Nullable |
| `created_at` | `TIMESTAMP` | Gerenciado pelo Eloquent |
| `updated_at` | `TIMESTAMP` | Gerenciado pelo Eloquent |

**`products`**

| Campo | Tipo | Detalhe |
|-------|------|---------|
| `id` | `BIGINT PK` | Auto-incremento |
| `nome` | `VARCHAR(255)` | — |
| `descricao` | `TEXT` | Nullable |
| `preco` | `DECIMAL(10,2)` | — |
| `estoque` | `INTEGER` | Default 0 |
| `categoria_id` | `BIGINT FK` | → `categories.id` |
| `created_at` | `TIMESTAMP` | Gerenciado pelo Eloquent |
| `updated_at` | `TIMESTAMP` | Gerenciado pelo Eloquent |

---

## Decisões de Implementação

Estas decisões foram tomadas para garantir paridade com a implementação Django e validade metodológica do TCC:

- **Autenticação via Laravel Sanctum (Bearer Token):** O token é retornado no login/registro e enviado via cabeçalho `Authorization: Bearer <token>`, padrão idêntico ao adotado na API Django para eliminar variáveis de protocolo.

- **Middleware `ForceJsonResponse`:** Garante que a API sempre retorne `Content-Type: application/json`, independentemente do cabeçalho `Accept` enviado pelo cliente. Isso evita que o Laravel retorne HTML em situações inesperadas durante os testes de carga.

- **API Resources para serialização:** Os campos são renomeados para português (`criado_em`, `atualizado_em`) via `ProductResource` e `CategoryResource`, mantendo paridade total com o JSON retornado pelo Django.

- **Eager Loading (JOIN):** A listagem de produtos utiliza `with('categoria')`, evitando o problema de N+1 queries e tornando a comparação de desempenho com o Django mais precisa.

- **Connection Pooling via PgBouncer:** A infraestrutura Docker inclui um contêiner PgBouncer (porta `6432`). Os testes são executados em dois cenários: conectando diretamente ao PostgreSQL (porta `5432`) e via PgBouncer, variando apenas a variável de ambiente `DB_HOST` no `.env`.
