# 📊 Sistema de Controle de Projetos

Sistema completo para gestão e controle de projetos desenvolvido com PHP e JavaScript, oferecendo interface intuitiva para gerenciamento de projetos, líderes e equipes.

## 🚀 Funcionalidades

### Gestão de Projetos
- ✅ Cadastro completo de projetos com informações detalhadas
- 📝 Controle de status (Em Andamento, Espera, Concluído, Cancelado)
- 👥 Gestão de equipes e líderes por projeto
- 📅 Controle de datas (início, entrega, conclusão)
- 🏢 Gerenciamento de clientes e áreas
- 📊 Dashboards com gráficos e estatísticas
- 🔍 Sistema de busca e filtros avançados
- 📤 Exportação de dados para Excel

### Recursos Adicionais
- 💯 Cálculo de eficiência dos projetos
- 📈 Indicadores de performance
- 🎨 Interface responsiva e moderna
- 💾 Backup automático de dados
- 🔄 Sincronização em tempo real com banco de dados

## 🛠️ Tecnologias Utilizadas

### Frontend
- HTML5
- CSS3 (Design responsivo)
- JavaScript (ES6+)
- Font Awesome 6.4.0 (Ícones)
- Chart.js (Gráficos)
- SheetJS (Exportação Excel)

### Backend
- PHP 7.4+
- MySQL 5.7+

### Servidor
- XAMPP (Apache + MySQL)

## 📋 Pré-requisitos

- XAMPP instalado
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Navegador web moderno (Chrome, Firefox, Edge)

## ⚙️ Instalação

1. **Clone ou copie o projeto para a pasta do XAMPP:**
   ```bash
   c:\xampp\htdocs\controle\
   ```

2. **Configure o banco de dados:**
   - Inicie o XAMPP Control Panel
   - Inicie os serviços Apache e MySQL
   - Acesse phpMyAdmin: `http://localhost/phpmyadmin`
   - Crie o banco de dados `gestao_projetos`

3. **Configure a conexão com o banco de dados:**
   - Edite o arquivo [db.php](db.php)
   - Atualize as credenciais conforme necessário:
   ```php
   $DB_HOST = "127.0.0.1";
   $DB_USER = "root";
   $DB_PASS = "sua_senha";
   $DB_NAME = "gestao_projetos";
   $DB_PORT = 3306;
   ```

4. **Execute o script de diagnóstico das tabelas:**
   ```
   http://localhost/controle/diagnostico_tabelas.php
   ```
   Este script criará automaticamente as tabelas necessárias.

5. **Acesse o sistema:**
   ```
   http://localhost/controle/
   ```

## 📁 Estrutura do Projeto

```
controle/
├── index.html                 # Interface principal do sistema
├── db.php                     # Configuração e conexão com banco de dados
├── buscar.php                 # API para buscar projetos e líderes
├── salvar_projeto.php         # API para salvar/atualizar projetos
├── salvar_lider.php           # API para salvar/atualizar líderes
├── delete_project.php         # API para excluir projetos
├── delete_leader.php          # API para excluir líderes
├── diagnostico_tabelas.php    # Script de diagnóstico e criação de tabelas
├── teste_conexao.php          # Script de teste de conexão com BD
└── README.md                  # Documentação do projeto
```

## 🗄️ Estrutura do Banco de Dados

### Tabela: `projetos_backup`
Armazena os projetos com todas as informações em formato JSON.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT | ID único do projeto |
| cliente | VARCHAR(255) | Nome do cliente |
| nome_projeto | VARCHAR(255) | Nome do projeto |
| dados_completos | TEXT | Dados completos em JSON |

### Tabela: `lideres_backup`
Armazena os líderes e suas informações.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT | ID único do líder |
| dados_lider | TEXT | Dados do líder em JSON |

## 🔧 Uso do Sistema

### Adicionar Novo Projeto
1. Clique no botão "➕ Novo Projeto"
2. Preencha as informações do projeto
3. Defina a equipe e líder
4. Defina datas e status
5. Clique em "Salvar Projeto"

### Gerenciar Líderes
1. Clique no botão "👥 Gerenciar Líderes"
2. Adicione novos líderes ou edite existentes
3. Os líderes estarão disponíveis para atribuição aos projetos

### Filtrar Projetos
- Use os filtros disponíveis no topo da página
- Filtre por cliente, status, líder, área, etc.
- Combine múltiplos filtros para busca avançada

### Exportar Dados
- Clique no botão "📥 Exportar Excel"
- O sistema gerará um arquivo .xlsx com todos os projetos filtrados

## 🔍 Diagnóstico e Testes

### Testar Conexão com Banco de Dados
```
http://localhost/controle/teste_conexao.php
```

### Diagnosticar Tabelas
```
http://localhost/controle/diagnostico_tabelas.php
```

## 🐛 Troubleshooting

### Erro de Conexão
- Verifique se o MySQL está rodando no XAMPP
- Confirme as credenciais em [db.php](db.php)
- Execute [teste_conexao.php](teste_conexao.php)

### Tabelas Não Encontradas
- Execute [diagnostico_tabelas.php](diagnostico_tabelas.php)
- Verifique os logs de erro no arquivo `debug.log`

### Problemas ao Salvar Dados
- Verifique permissões de escrita no diretório
- Consulte o arquivo `debug.log` para detalhes
- Verifique o console do navegador (F12)

## 📝 Logs

O sistema gera logs de debug no arquivo `debug.log` na raiz do projeto. Consulte este arquivo em caso de erros.

## 🔒 Segurança

⚠️ **Importante para Produção:**
- Altere as credenciais padrão do banco de dados
- Implemente autenticação de usuários
- Use prepared statements (já implementado)
- Configure HTTPS
- Restrinja acesso aos arquivos PHP sensíveis
- Desabilite `display_errors` em produção

## 🤝 Contribuições

Contribuições são bem-vindas! Sinta-se à vontade para:
- Reportar bugs
- Sugerir novas funcionalidades
- Enviar pull requests
- Melhorar a documentação

## 📄 Licença

Este projeto é livre para uso pessoal e comercial.

## 👨‍💻 Autor

Desenvolvido com ❤️ para gestão eficiente de projetos.

---

**Versão:** 1.0  
**Última atualização:** Janeiro 2026
