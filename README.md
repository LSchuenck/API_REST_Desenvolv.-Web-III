# Biblioteca API

API REST desenvolvida em **Laravel** para a disciplina **Desenvolvimento Web III** (IF Sudeste MG – Campus Muriaé).

Disponibiliza informações sobre **livros, autores, categorias e usuários**, com operações de consulta, cadastro, alteração e exclusão. As respostas são em **JSON** e a autenticação usa **Laravel Sanctum**.

## Tecnologias

- PHP 8.2+
- Laravel 12
- MySQL / MariaDB
- Laravel Sanctum (autenticação por token)

## Modelo de dados

```
autor (idautor, nome, nacionalidade, nascimento, biografia)
  1 ──── N
livro (idlivro, titulo, isbn, anopublicacao, descricao, paginas, idautor, idcategoria)
  N ──── 1
categoria (idcategoria, nome, descricao)

users (id, name, email, password)
```

As tabelas são criadas pelas **migrations** do Laravel (`database/migrations`).

---

## Como rodar o projeto

### 1. Instalar

```bash
git clone <url-deste-repositorio>
cd biblioteca-api
composer install
cp .env.example .env
php artisan key:generate
```

### 2. Configurar o banco

Crie um banco vazio chamado `biblioteca_api` (pelo phpMyAdmin, Workbench ou terminal):

```sql
CREATE DATABASE biblioteca_api CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Confira os dados de conexão no arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=biblioteca_api
DB_USERNAME=root
DB_PASSWORD=
```

> O projeto foi desenvolvido com o MariaDB do XAMPP na porta **3307**. Se o seu banco usa a porta padrão, troque para `DB_PORT=3306`.

### 3. Criar as tabelas e ligar a API

```bash
php artisan migrate
php artisan serve
```

A API fica disponível em `http://localhost:8000/api`.

Teste rápido: abra http://localhost:8000/api/livros no navegador. Se aparecer `[]`, está funcionando (a lista só está vazia).

---

## Como testar no Postman

A coleção com todas as requisições está em [`postman/Biblioteca-API.postman_collection.json`](postman/Biblioteca-API.postman_collection.json).

1. No Postman, clique em **Import** e selecione o arquivo da coleção.
2. Execute as requisições **nesta ordem** (cada uma depende da anterior):

| # | Requisição | Resultado esperado |
|---|---|---|
| 1 | **Autenticação → Registrar** | `201` e um `token` (salvo automaticamente) |
| 2 | **Autores → Cadastrar** | `201`, autor com `idautor: 1` |
| 3 | **Categorias → Cadastrar** | `201`, categoria com `idcategoria: 1` |
| 4 | **Livros → Cadastrar** | `201` |
| 5 | **Livros → Listar** | o livro **com os dados do autor e da categoria** |
| 6 | **Livros → Atualizar** | páginas alteradas para 300 |
| 7 | **Usuários → Listar** | o usuário registrado no passo 1 |
| 8 | **Livros → Remover** | `204` (sem conteúdo) |

Se o **Registrar** responder que o e-mail já está cadastrado, use **Autenticação → Login**: ele também salva o token.

**Testando a autenticação:** execute **Autenticação → Logout** e depois **Autores → Cadastrar**. A resposta deve ser `401 "Não autenticado."`. Faça Login de novo para voltar a ter acesso.

**Testando a validação:** em **Livros → Cadastrar**, remova o `titulo` do corpo e envie. A resposta deve ser `422 "O campo titulo é obrigatório."`.

### Testando pelo terminal (curl)

```bash
# Consulta pública
curl http://localhost:8000/api/livros

# Login (copie o token da resposta)
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "lucas@email.com", "password": "123456"}'

# Cadastro (rota protegida)
curl -X POST http://localhost:8000/api/autores \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -d '{"nome": "Machado de Assis"}'
```

### Problemas comuns

| Erro | Causa |
|---|---|
| `Could not send request` no Postman | O `php artisan serve` não está rodando |
| `SQLSTATE[HY000] [2002]` | O banco não está ligado ou a porta do `.env` está errada |
| `401` em Cadastrar / Atualizar / Remover | Falta fazer o Login (ou foi feito Logout) |
| `422` ao cadastrar livro | O autor ou a categoria informados ainda não existem |

---

## Endpoints

**Públicos:** consultas (GET) de autores, categorias e livros, além de `register` e `login`.
**Protegidos:** cadastro, alteração e exclusão, e todas as rotas de usuários. Exigem o header `Authorization: Bearer {token}`.

### Autenticação

| Método | Rota | Descrição | Acesso |
|---|---|---|---|
| POST | `/api/register` | Cadastra um usuário e retorna o token | Público |
| POST | `/api/login` | Autentica e retorna o token | Público |
| GET | `/api/me` | Dados do usuário logado | Token |
| POST | `/api/logout` | Invalida o token atual | Token |

### Autores

| Método | Rota | Descrição | Acesso |
|---|---|---|---|
| GET | `/api/autores` | Lista os autores cadastrados | Público |
| GET | `/api/autores/{id}` | Retorna os dados de um autor | Público |
| POST | `/api/autores` | Cadastra um novo autor | Token |
| PUT | `/api/autores/{id}` | Atualiza um autor | Token |
| DELETE | `/api/autores/{id}` | Remove um autor | Token |

### Categorias

| Método | Rota | Descrição | Acesso |
|---|---|---|---|
| GET | `/api/categorias` | Lista as categorias cadastradas | Público |
| GET | `/api/categorias/{id}` | Retorna os dados de uma categoria | Público |
| POST | `/api/categorias` | Cadastra uma nova categoria | Token |
| PUT | `/api/categorias/{id}` | Atualiza uma categoria | Token |
| DELETE | `/api/categorias/{id}` | Remove uma categoria | Token |

### Livros

| Método | Rota | Descrição | Acesso |
|---|---|---|---|
| GET | `/api/livros` | Lista os livros **com autor e categoria** | Público |
| GET | `/api/livros/{id}` | Retorna um livro **com autor e categoria** | Público |
| POST | `/api/livros` | Cadastra um novo livro | Token |
| PUT | `/api/livros/{id}` | Atualiza um livro | Token |
| DELETE | `/api/livros/{id}` | Remove um livro | Token |

### Usuários

| Método | Rota | Descrição | Acesso |
|---|---|---|---|
| GET | `/api/usuarios` | Lista os usuários | Token |
| GET | `/api/usuarios/{id}` | Retorna os dados de um usuário | Token |
| POST | `/api/usuarios` | Cadastra um usuário | Token |
| PUT | `/api/usuarios/{id}` | Atualiza um usuário | Token |
| DELETE | `/api/usuarios/{id}` | Remove um usuário | Token |

### Exemplo de resposta: `GET /api/livros/1`

```json
{
  "idlivro": 1,
  "titulo": "Dom Casmurro",
  "isbn": "9788535910663",
  "anopublicacao": 1899,
  "descricao": "Bentinho e o ciúme de Capitu.",
  "paginas": 256,
  "idautor": 1,
  "idcategoria": 1,
  "autor": {
    "idautor": 1,
    "nome": "Machado de Assis",
    "nacionalidade": "Brasileira",
    "nascimento": "1839-06-21",
    "biografia": "Escritor brasileiro, fundador da Academia Brasileira de Letras."
  },
  "categoria": {
    "idcategoria": 1,
    "nome": "Romance",
    "descricao": "Narrativas de ficção em prosa."
  }
}
```

### Códigos de resposta

| Código | Significado |
|---|---|
| `200` | Sucesso |
| `201` | Registro criado |
| `204` | Registro removido (sem conteúdo) |
| `401` | Não autenticado (sem token, token inválido ou login incorreto) |
| `404` | Registro não encontrado |
| `422` | Erro de validação (os detalhes vêm em `errors`) |
