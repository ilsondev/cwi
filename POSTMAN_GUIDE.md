# Como Usar os Arquivos do Postman

## Arquivos Criados

1. **`postman_collection.json`** - Coleção completa com todos os endpoints
2. **`postman_environment.json`** - Ambiente de desenvolvimento com variáveis

## Importando no Postman

### 1. Importar a Coleção

1. Abra o Postman
2. Clique em **Import** (no canto superior esquerdo)
3. Selecione o arquivo `postman_collection.json`
4. Clique em **Import**
5. Clique em **Import** novamente (no canto superior esquerdo)
6. Selecione o arquivo `postman_environment.json`
7. Clique em **Import**

### 3. Ativar o Ambiente

1. No canto superior direito do Postman, você verá um dropdown de ambientes
2. Selecione **CWI Test - Development**

## Estrutura da Coleção

### 📋 Health Checks
- **Laravel Health Check** - Verifica se a API Laravel está funcionando
- **Microservice Health Check (Direct)** - Testa o microsserviço diretamente
- **Microservice Health Check (via Laravel)** - Testa o microsserviço através do Laravel

### 👥 Users CRUD
- **Get All Users** - Lista todos os usuários
- **Create User** - Cria um novo usuário
- **Get User by ID** - Busca usuário por ID
- **Update User** - Atualiza dados do usuário
- **Update User Password** - Atualiza apenas a senha
- **Delete User** - Remove um usuário

### 🔄 Microservice Integration
- **Get Services from Microservice** - Busca serviços via Laravel
- **Validate User via Microservice** - Valida email via microsserviço

### 🎯 Direct Microservice Calls
- **Get Services (Direct)** - Chama diretamente o microsserviço
- **Get Service by ID (Direct)** - Busca serviço específico
- **Validate User (Direct)** - Validação direta no microsserviço

### 🧪 Test Scenarios
- **Create Multiple Users** - Scripts para criar vários usuários
- **Error Test Cases** - Testes de validação e casos de erro

## Variáveis Configuradas

- `{{base_url}}` - http://localhost:8000 (Laravel)
- `{{microservice_url}}` - http://localhost:3000 (Node.js)
- `{{user_id}}` - ID do usuário para testes

## Como Testar

### 1. Verificar se os Serviços Estão Funcionando

Execute primeiro os health checks:
1. **Laravel Health Check**
2. **Microservice Health Check (Direct)**
3. **Microservice Health Check (via Laravel)**

### 2. Testar o CRUD de Usuários

1. Execute **Create User** para criar um usuário
2. Copie o `id` retornado na resposta
3. Atualize a variável `user_id` no ambiente com esse ID
4. Execute os demais endpoints (Get, Update, Delete)

### 3. Testar Integração com Microsserviço

1. Execute **Get Services from Microservice**
2. Execute **Validate User via Microservice**
3. Compare com as chamadas diretas

### 4. Testar Cenários de Erro

Execute os testes na pasta **Error Test Cases** para verificar:
- Validação de email inválido
- Senha muito curta
- Usuário inexistente
- Etc.

## Dicas de Uso

### Executando Todos os Testes

1. Clique com o botão direito na coleção **CWI Test - Laravel API**
2. Selecione **Run collection**
3. Configure os parâmetros desejados
4. Clique em **Run CWI Test - Laravel API**

## Troubleshooting

### Erro de Conexão
- Verifique se o Docker está rodando: `docker ps`
- Verifique se os containers estão ativos
- Teste as URLs diretamente no navegador

### Microsserviço Não Responde
- Verifique os logs: `docker logs cwi-microservice`
- Teste a URL direta: http://localhost:3000/health

### Laravel Não Responde
- Verifique os logs: `docker logs cwi-app`
- Teste a URL direta: http://localhost:8000/api/health

## URLs de Teste Rápido

- Laravel: http://localhost:8000/api/health
- Microsserviço: http://localhost:3000/health
- Lista de usuários: http://localhost:8000/api/users
- Serviços do microsserviço: http://localhost:3000/services


(Sim, usei GenAI para criar a documentação ^^)
