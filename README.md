# Sistema de Gestão Econômica

Este é um sistema de gestão para grupos econômicos, bandeiras, unidades e colaboradores, desenvolvido em Laravel 10 com Livewire.

## 🚀 Funcionalidades

* CRUD completo de Grupos Econômicos
* CRUD completo de Bandeiras (com relacionamento)
* CRUD completo de Unidades (com relacionamento)
* CRUD completo de Colaboradores (com relacionamento)
* Relatório de Colaboradores com filtros em cascata
* Autenticação com Laravel Breeze
* Exportação de Relatórios para Excel (com Fila)
* Auditoria de todas as ações (Create, Update, Delete)
* Testes unitários (Pest)

## 🛠️ Stack Tecnológica

* **Laravel 10**
* **PHP 8.x**
* **Livewire 3**
* **MySQL**
* **Laravel Sail** (Docker)
* **Redis** (para Filas)
* **Maatwebsite/Excel**
* **Laravel Auditing**

---

## 🏁 Como Rodar (Instalação)

### Pré-requisitos

* [Docker Desktop](https://www.docker.com/products/docker-desktop/)
* [WSL 2](https://learn.microsoft.com/pt-br/windows/wsl/install) (para usuários Windows)

### Passos da Instalação

1.  **Clone o repositório:**
    ```bash
    # SUBSTITUA PELA URL DO SEU REPOSITÓRIO
    git clone [https://github.com/Gsoares8/gestao-economica-Projeto-Voch-Tech](https://github.com/Gsoares8/gestao-economica-Projeto-Voch-Tech)
    cd gestao-economica-Projeto-Voch-Tech
    ```

2.  **Copie o arquivo de ambiente:**
    ```bash
    cp .env.example .env
    ```

3.  **Inicie o Laravel Sail:**
    (Este comando irá baixar as imagens Docker do PHP, MySQL e Redis e "ligar" o ambiente. Pode demorar na primeira vez.)
    ```bash
    ./vendor/bin/sail up -d
    ```

4.  **Instale as dependências do Composer:**
    ```bash
    ./vendor/bin/sail composer install
    ```

5.  **Gere a Chave da Aplicação:**
    ```bash
    ./vendor/bin/sail php artisan key:generate
    ```

6.  **Rode as Migrações (Crie as tabelas):**
    (Isso irá criar todas as tabelas, incluindo `users`, `audits`, `grupos_economicos`, etc.)
    ```bash
    ./vendor/bin/sail php artisan migrate
    ```

7.  **Crie o Link de Storage:**
    (Necessário para que os relatórios exportados sejam acessíveis)
    ```bash
    ./vendor/bin/sail php artisan storage:link
    ```

8.  **Instale as dependências do Front-end:**
    ```bash
    ./vendor/bin/sail npm install
    ```

9.  **Compile o Front-end:**
    ```bash
    ./vendor/bin/sail npm run build
    ```

10. **Inicie o "Trabalhador" da Fila (Obrigatório):**
    (Este comando precisa ficar rodando em um terminal separado para processar as exportações de Excel.)
    ```bash
    ./vendor/bin/sail php artisan queue:work
    ```

### 🚀 Acesso

Após todos os passos, a aplicação estará rodando!

* **URL:** [http://localhost](http://localhost)
* **Usuário:** Você pode se registrar na tela de "Register" para criar seu primeiro usuário.