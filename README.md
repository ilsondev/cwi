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

### Opção 1: Usando Postman (Recomendado)

**Arquivos Postman incluídos:**
- `postman_collection.json` - Coleção completa com todos os endpoints
- `postman_environment.json` - Ambiente de desenvolvimento
- `POSTMAN_GUIDE.md` - Guia detalhado de como usar

**Como importar:**
1. Abra o Postman
2. Importe o arquivo `postman_collection.json`
3. Importe o arquivo `postman_environment.json`
4. Selecione o ambiente "CWI Test - Development"
5. Execute os testes na ordem sugerida

### Opção 2: Linha de Comando (cURL)

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
