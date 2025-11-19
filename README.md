# Delta Vistoria — Sistema Web de Agendamentos e Gerenciamento

## 📌 Sobre o Projeto
Este projeto foi desenvolvido para fins acadêmicos na disciplina de Programação Web, utilizando **PHP**, **HTML**, **CSS**, **JavaScript** e o ambiente **XAMPP**.

A aplicação representa a transformação digital de uma empresa real chamada **Delta Vistória**, situada na região metropolitana de João Pessoa. A empresa atua com:

- Vistoria Veicular  
- Vistoria Cautelar  
- Transferência de Propriedade  

Atualmente, a empresa utiliza apenas redes sociais para comunicação com seus clientes. O objetivo deste sistema é permitir sua inserção na web através de uma plataforma funcional, moderna e intuitiva.

---

## 👥 Integrantes do Grupo
- **Fernando Wernner**  
- **Hiago Silva**  
- **Ryan Lustosa**  
- **João Vitor Fujarra**  
- **Gutemberg Cezar**

---

## 🎯 Objetivo da Aplicação
A aplicação foi projetada com duas áreas principais:

### **1. Área Pública (Cliente):**
- Apresentação institucional da empresa  
- Informações sobre os serviços prestados  
- Página “Quem Somos”  
- Página de Localização  
- Formulário público para **agendamento de vistoria**  
- Contato direto com a empresa  

### **2. Área Administrativa (Restrita ao Funcionário):**
- Login de funcionário  
- CRUD completo de **Clientes**  
- CRUD completo de **Agendamentos**  
- Visualização e gerenciamento dos agendamentos realizados pelos clientes  
- Edição e exclusão de registros  

---

## 🛠 Tecnologias Utilizadas
- **PHP 7+**
- **HTML5**
- **CSS3**
- **JavaScript**
- **MySQL (via XAMPP)**
- **Apache (XAMPP)**

---

## 💾 Banco de Dados
O banco utilizado chama-se **delta_vistoria**.

O projeto inclui um arquivo `.sql` com as tabelas:

- **clientes**
- **agendamentos**

---

## 🚀 Como Executar o Projeto no XAMPP

### **1. Instale o XAMPP**
Baixe e instale no site oficial:  
https://www.apachefriends.org/

### **2. Inicie os serviços**
Abra o painel do XAMPP e ligue:
- Apache  
- MySQL  

### **3. Importe o banco de dados**
1. Acesse `localhost/phpmyadmin`  
2. Clique em **Importar**  
3. Selecione o arquivo `delta_vistoria.sql`  
4. Execute a importação

### **4. Coloque o projeto na pasta htdocs**
Copie a pasta do projeto para: C:\xampp\htdocs\delta_vistoria

### **5. Acesse o sistema no navegador**
- **Área pública:**  
  http://localhost/delta_vistoria/public/

- **Área administrativa:**  
  http://localhost/delta_vistoria/admin/login.php

---

## 📸 Funcionalidades Implementadas
- Página inicial institucional  
- Sistema de agendamento para o cliente  
- Formulários validados (JS + PHP)  
- Dashboard administrativo  
- CRUD de clientes  
- CRUD de agendamentos  
- Controle de sessão e login do administrador  
- Layout simples e responsivo  

---

## 📄 Licença
Projeto desenvolvido exclusivamente para fins educacionais.

---

## 💬 Contato
Para dúvidas, sugestões ou melhorias, consulte os integrantes do grupo.