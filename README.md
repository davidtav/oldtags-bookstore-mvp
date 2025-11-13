# 📚 OldTags Bookstore MVP

Uma loja virtual de livros usados de tecnologia construída como um Mínimo Produto Viável (MVP) em um **ambiente de estudo e prototipagem**. O projeto foi desenvolvido para testar a integração entre ferramentas de **Low-Code/No-Code** e o desenvolvimento tradicional (Laravel/PHP).

A **Interface de Usuário (UI)** foi iniciada usando a plataforma de IA generativa **Lovable**, e o código resultante foi adaptado e integrado a uma stack moderna: Laravel, Supabase, Tailwind e Alpine.js.

O repositório original da UI gerada pelo Lovable pode ser encontrado aqui: [https://github.com/davidtav/oldtags](https://github.com/davidtav/oldtags)

***

## 🚀 Stack Tecnológica Principal

Este projeto utiliza o conceito de *Composable Architecture*, combinando ferramentas *server-side* e *client-side* para máxima agilidade.

| Componente | Tecnologia | Função no Projeto |
| :--- | :--- | :--- |
| **Backend / Core** | **Laravel (PHP)** | Gerenciamento de rotas e processamento simulado do Checkout (`/api/checkout`). |
| **Frontend Rendering** | **Blade (Laravel)** | Renderização das *views* (Catálogo e Carrinho). |
| **Data & Auth (BaaS)** | **Supabase** | Backend as a Service (BaaS) para o banco de dados (`livros`) e API REST. |
| **Interatividade (JS)** | **Alpine.js** | Gerenciamento de estado (*state management*), filtros e lógica de carrinho no *frontend*. |
| **Estilização (CSS)** | **Tailwind CSS** | Framework *utility-first* para design responsivo e rápido. |

***

## 💻 Funcionalidades do MVP

As funcionalidades atuais do projeto cobrem o ciclo de compra básico:

* **Catálogo Dinâmico:** Exibição de livros buscados em tempo real do Supabase.
* **Filtros & Busca:** Funcionalidade de busca por título/autor e filtro por condição (`Novo`, `Usado`) em tempo real (via Alpine.js).
* **Carrinho Local:** Adição e remoção de itens, com persistência dos dados no **LocalStorage** (`oldtags_cart`).
* **Checkout Simulado:** O botão "Finalizar Compra" envia o pedido (JSON) para o endpoint do Laravel, que loga os detalhes do pedido no servidor (terminal).

***

## ⚙️ Instalação e Configuração Local

Siga estas instruções para colocar o projeto em funcionamento em sua máquina:

### 1. Pré-requisitos

Certifique-se de que você tem: PHP (v8.1+), Composer, e ambiente de servidor (Laragon, XAMPP, etc.).

### 2. Clonar e Instalar


# 1. Clone o repositório (o projeto Laravel)
```bash
git clone [URL_DO_SEU_REPOSITORIO] oldtags-bookstore-mvp
cd oldtags-bookstore-mvp
```
# 2. Instalar dependências do PHP
```bash
composer install
```

# 3. Configurar o ambiente
```bash
cp .env.example .env
```
# 4. Gerar chave da aplicação
```bash
php artisan key:generate
```
# 5. Configuração do Supabase
Para conectar o catálogo ao banco de dados, você precisa de um projeto Supabase configurado:

Crie uma conta no Supabase e configure a tabela livros com as colunas essenciais: id, titulo, autor, preco, condicao, capa_url.

Desative o RLS (Row Level Security) na tabela livros para permitir que o frontend leia os dados publicamente.

Adicione as chaves de conexão ao seu arquivo .env:
```bash
SUPABASE_URL="SEU_URL_DO_PROJETO"
SUPABASE_KEY="SUA_CHAVE_PÚBLICA_ANON"
```

# 6. Executar o Projeto
# Limpar cache de configuração após alterar o .env
```bash
php artisan config:clear
```

# Iniciar o servidor
```bash
php artisan serve
```
A aplicação estará acessível em http://127.0.0.1:8000.
