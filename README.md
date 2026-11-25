# ConectaBairro — Bairro Uninove

Protótipo acadêmico de plataforma comunitária. A versão inicial possui cadastro/login e CRUD funcional de pedidos de ajuda. Avisos, eventos e comércio local aparecem como áreas previstas para evolução do projeto.

## Requisitos
- XAMPP (Apache + MySQL) ou ambiente equivalente
- PHP 8 ou superior, com PDO MySQL habilitado
- MySQL/MariaDB

## Instalação rápida com XAMPP
1. Copie a pasta `ConectaBairro` para `C:\xampp\htdocs\`.
2. Abra o XAMPP Control Panel e inicie **Apache** e **MySQL**.
3. Acesse `http://localhost/phpmyadmin`.
4. Clique em **Importar**, selecione `database.sql` e execute.
5. Confira `config.php`. No XAMPP padrão, usuário `root` e senha vazia.
6. Acesse `http://localhost/ConectaBairro/`.
7. Crie uma conta pela tela inicial e entre com ela.

## Teste para a apresentação
1. Faça cadastro e login.
2. Cadastre um pedido de ajuda com título, descrição e categoria.
3. Mostre o pedido na lista.
4. Clique em **Editar**, altere o status para “Em andamento” e salve.
5. Mostre a alteração.
6. Clique em **Excluir** e confirme.
7. Mostre que o pedido não aparece mais.

## Estrutura
- `index.php`: cadastro, login, painel e CRUD de pedidos de ajuda.
- `config.php`: conexão com MySQL.
- `database.sql`: criação das cinco tabelas.
- `assets/style.css`: aparência responsiva.

## Observações importantes
- O sistema é um protótipo acadêmico para demonstração, não uma plataforma pronta para uso público.
- Os módulos de avisos, eventos e comércio estão representados como áreas previstas, mas ainda não possuem telas de cadastro/edição.
- Para publicar na internet, será necessário reforçar segurança, permissões, validações, proteção contra CSRF e configuração do servidor.
- Não cadastre dados pessoais reais de moradores na demonstração.
