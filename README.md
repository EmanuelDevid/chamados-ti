# 🛠️ SEDHAS TI - Sistema de Gestão de Chamados

Sistema web para gerenciamento e triagem de chamados da TI da Secretaria dos Direitos Humanos e Assistência Social (SEDHAS). Desenvolvido com **Laravel 11**, **Livewire 3** e **Tailwind CSS**.

---

## 🚀 Tecnologias Utilizadas

* **Framework:** Laravel 13
* **Reatividade:** Livewire 3
* **Estilização:** Tailwind CSS (Institutional Blue UI)
* **Banco de Dados:** MySQL
* **Autenticação:** Custom Auth (Livewire)

---

## 🔐 Controle de Acesso e Perfis

O sistema possui controle de visibilidade dinâmico baseado no perfil do usuário:

* **Servidor Comum (`/my-tickets`):** Criação de novos chamados e visualização exclusiva das suas próprias solicitações.
* **Equipe de TI / Admin (`/tickets`):** Acesso restrito à **Fila de Atendimento** completa para gerenciamento e suporte.

---

## 🧮 Cálculo Automático de Prioridade

A priorização dos chamados é calculada automaticamente na criação utilizando os parâmetros:
* **Peso do Subtipo** de atendimento selecionado.
* **Escopo da Solicitação** (Individual, Equipe ou Setor).
* **Criticidade do Setor** solicitante.

---

## ⚙️ Instalação e Execução Local

```bash
# Clone o repositório
git clone [https://github.com/EmanuelDevid/chamados-ti.git](https://github.com/EmanuelDevid/chamados-ti.git)

# Acesse o diretório
cd chamados-ti

# Instale as dependências do PHP
composer install

# Instale as dependências do Node
npm install && npm run dev

# Configure o arquivo .env
cp .env.example .env
php artisan key:generate

# Execute as migrações e seeders
php artisan migrate

# Inicie o servidor de desenvolvimento
php artisan serve