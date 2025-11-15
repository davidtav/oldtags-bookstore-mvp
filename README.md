# 📚 OldTags Bookstore — MVP

![Laravel](https://img.shields.io/badge/Laravel-v12-red?logo=laravel)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-v4.0-blue?logo=tailwindcss)
![Supabase](https://img.shields.io/badge/Supabase-BaaS-green?logo=supabase)
![License](https://img.shields.io/badge/License-MIT-yellow?logo=open-source-initiative)

Uma **loja virtual de livros usados de tecnologia**, construída como um **Mínimo Produto Viável (MVP)** em um ambiente de **estudo e prototipagem**.

O objetivo deste projeto é explorar a integração entre ferramentas de **Low-Code/No-Code** e o desenvolvimento tradicional com **Laravel/PHP**.

A **Interface de Usuário (UI)** foi inicialmente criada com a plataforma de IA generativa **Lovable**, e posteriormente adaptada e integrada a uma stack moderna:

> **Laravel**, **Supabase**, **Tailwind CSS** e **Alpine.js**.

🔗 Repositório original da UI gerada pelo Lovable:  
[github.com/davidtav/oldtags](https://github.com/davidtav/oldtags)

---

## 🚀 Stack Tecnológica

O projeto segue o conceito de **Composable Architecture**, combinando ferramentas *server-side* e *client-side* para maior agilidade no desenvolvimento.

| Componente | Tecnologia | Função |
| :--- | :--- | :--- |
| **Backend / Core** | **Laravel (PHP)** | Gerencia rotas e processa o Checkout simulado (`/api/checkout`). |
| **Frontend Rendering** | **Blade (Laravel)** | Renderização das *views* (Catálogo e Carrinho). |
| **Data & Auth (BaaS)** | **Supabase** | Banco de dados e API REST para os livros. |
| **Interatividade (JS)** | **Alpine.js** | Gerencia estados, filtros e lógica do carrinho no *frontend*. |
| **Estilização (CSS)** | **Tailwind CSS** | Framework *utility-first* para design responsivo. |

---

## 💻 Funcionalidades do MVP

As funcionalidades atuais cobrem o ciclo básico de compra:

- 🧾 **Catálogo Dinâmico:** Exibe livros em tempo real a partir do Supabase.  
- 🔍 **Busca & Filtros:** Pesquisa por título/autor e filtro por condição (`Novo` / `Usado`) em tempo real.  
- 🛒 **Carrinho Local:** Adição, remoção e persistência dos itens via **LocalStorage** (`oldtags_cart`).  
- 💳 **Checkout Simulado:** Envio de pedidos (JSON) para o endpoint Laravel, com log do pedido no terminal.

---

## ⚙️ Instalação e Configuração Local

### 🧰 1. Pré-requisitos

Certifique-se de ter instalado:

- PHP **v8.1+**
- **Composer**
- Um ambiente de servidor (ex: **Laragon**, **XAMPP**, etc.)

---

### 📦 2. Clonar e Instalar o Projeto

```bash
git clone https://github.com/davidtav/oldtags-bookstore-mvp.git
cd oldtags-bookstore-mvp
composer install
```

---

### ⚙️ 3. Configurar o Ambiente

Crie o arquivo de ambiente e gere a chave da aplicação:

```bash
cp .env.example .env
php artisan key:generate
```

---

### 🗄️ 4. Configurar o Supabase

Para conectar o catálogo ao banco de dados:

1. Crie um projeto no **Supabase**.
2. Crie a tabela `livros` com as colunas:
   - `id`, `titulo`, `autor`, `preco`, `condicao`, `capa_url`
3. Desative o **RLS (Row Level Security)** para permitir leitura pública.
4. Adicione suas credenciais ao arquivo `.env`:

```bash
SUPABASE_URL="SEU_URL_DO_PROJETO"
SUPABASE_KEY="SUA_CHAVE_PÚBLICA_ANON"
```

---

### 🧹 5. Limpar Cache e Iniciar o Servidor

```bash
php artisan config:clear
php artisan serve
```

A aplicação estará disponível em:  
👉 **http://127.0.0.1:8000**

---

## 👨‍💻 Autor

**[David Mclaurel](https://www.linkedin.com/in/david-mclaurel/)**  


---

## 📝 Licença

Este projeto está sob a licença [MIT](./LICENSE).
