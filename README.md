# Gestão de Brinquedos

CRUD simples de brinquedos em PHP e MySQL. Permite cadastrar, listar, editar e excluir brinquedos com nome, categoria, faixa etária, preço e quantidade em estoque. As consultas ao banco usam PDO com Prepared Statements.

## Requisitos

- PHP 8.1 ou mais recente, com a extensão `pdo_mysql` habilitada
- MySQL ou MariaDB
- Um navegador

## Como executar

1. Inicie o MySQL e importe o arquivo `banco.sql` pelo phpMyAdmin ou pelo cliente MySQL. Ele cria o banco `gestao_brinquedos` e a tabela `brinquedos`.
2. Configure a conexão em `config.php` ou defina as variáveis de ambiente `DB_HOST`, `DB_NAME`, `DB_USER` e `DB_PASSWORD`. Os valores padrão são `localhost`, `gestao_brinquedos`, `root` e senha vazia.
3. Na pasta do projeto, inicie o servidor com `php -S localhost:8000` e abra `http://localhost:8000` no navegador. Se usar XAMPP, também pode copiar a pasta para `htdocs` e acessá-la pelo Apache.

Use ponto como separador decimal ao informar o preço no formulário, por exemplo `29.90`.

## Arquivos

- `banco.sql`: cria o banco e a tabela.
- `config.php`: conexão PDO.
- `brinquedos.php`: consultas preparadas e validação.
- `index.php`: formulário e listagem.
- `salvar.php`: cadastro e edição.
- `excluir.php`: exclusão.
