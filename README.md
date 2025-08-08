# CWI Test - Laravel CRUD com Microsserviço

Aplicação Laravel com CRUD de usuários e integração com microsserviço Node.js para processo seletivo.

## Funcionalidades

### Laravel API
- ✅ CRUD completo de usuários (nome, email, senha)
- ✅ Endpoint `/health` para health check
- ✅ Integração com microsserviço Node.js
- ✅ Validação de dados
- ✅ Responses padronizados JSON

### Microsserviço Node.js
- ✅ Health check endpoint
- ✅ Mock de serviços externos
- ✅ Validação de usuários
- ✅ API RESTful

## Tecnologias

- **Backend**: Laravel 11, PHP 8.3
- **Microsserviço**: Node.js, Express.js
- **Banco de Dados**: MySQL 8.0
- **Cache**: Redis
- **Containerização**: Docker, Docker Compose

## Instalação e Execução

### 1. Clone o repositório
```bash
git clone <repository-url>
cd cwi_test
```

### 2. Execute com Docker
```bash
docker compose up -d --build
```

### 3. Execute as migrações
```bash
docker exec -it cwi-app php artisan migrate
```

## Endpoints da API

### Laravel API (http://localhost:8000/api)

#### Health Check
```http
GET /api/health
```
**Response:**
```json
{
  "status": "ok"
}
```

#### Usuários

**Listar todos os usuários**
```http
GET /api/users
```

**Criar usuário**
```http
POST /api/users
Content-Type: application/json

{
  "name": "João Silva",
  "email": "joao@example.com",
  "password": "12345678"
}
```

**Buscar usuário por ID**
```http
GET /api/users/{id}
```

**Atualizar usuário**
```http
PUT /api/users/{id}
Content-Type: application/json

{
  "name": "João Santos",
  "email": "joao.santos@example.com"
}
```

**Deletar usuário**
```http
DELETE /api/users/{id}
```

#### Integração com Microsserviço

**Health check do microsserviço**
```http
GET /api/microservice/health
```

**Buscar serviços**
```http
GET /api/microservice/services
```

**Validar usuário**
```http
POST /api/microservice/validate-user
Content-Type: application/json

{
  "email": "user@example.com"
}
```

### Microsserviço Node.js (http://localhost:3000)

**Health Check**
```http
GET /health
```

**Listar serviços**
```http
GET /services
```

**Buscar serviço por ID**
```http
GET /services/{id}
```

**Validar usuário**
```http
POST /validate-user
Content-Type: application/json

{
  "email": "user@example.com"
}
```

## Estrutura do Projeto

```
cwi_test/
├── app/
│   ├── Http/Controllers/
│   │   ├── UserController.php          # CRUD de usuários
│   │   ├── HealthController.php        # Health check
│   │   └── MicroserviceController.php  # Integração com microsserviço
│   ├── Models/
│   │   └── User.php                    # Model de usuário
│   └── Services/
│       └── MicroserviceClient.php      # Cliente para microsserviço
├── microservice/
│   ├── index.js                        # Servidor Express.js
│   ├── package.json                    # Dependências Node.js
│   └── Dockerfile                      # Container do microsserviço
├── routes/
│   └── api.php                         # Rotas da API
├── database/
│   └── migrations/                     # Migrações do banco
├── docker-compose.yml                  # Orquestração dos containers
└── README.md                           # Este arquivo
```

## Testando a Aplicação

### 1. Verificar se os serviços estão funcionando
```bash
# Health check Laravel
curl http://localhost:8000/api/health

# Health check Microsserviço
curl http://localhost:3000/health
```

### 2. Criar um usuário
```bash
curl -X POST http://localhost:8000/api/users 
  -H "Content-Type: application/json" 
  -d '{
    "name": "Teste User",
    "email": "teste@example.com",
    "password": "12345678"
  }'
```

### 3. Listar usuários
```bash
curl http://localhost:8000/api/users
```

### 4. Testar integração com microsserviço
```bash
# Validar usuário através do microsserviço
curl -X POST http://localhost:8000/api/microservice/validate-user 
  -H "Content-Type: application/json" 
  -d '{"email": "teste@example.com"}'
```

## Requisitos Atendidos

- [x] CRUD de usuários (nome, email, senha)
- [x] Tabela users com id, name, email, password
- [x] Rotas: GET /users, POST /users, GET /users/{id}, PUT /users/{id}, DELETE /users/{id}
- [x] Endpoint GET /health retornando {"status": "ok"}
- [x] Microsserviço Node.js funcional
- [x] Integração entre Laravel e microsserviço
- [x] Documentação completa
- [x] Containerização com Docker

## Logs e Monitoramento

Para visualizar os logs dos containers:
```bash
# Logs do Laravel
docker logs cwi-app

# Logs do Microsserviço
docker logs cwi-microservice

# Logs do MySQL
docker logs cwi-mysql
```

## Parar a Aplicação

```bash
docker compose down
```

Para remover também os volumes:
```bash
docker compose down -v
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
