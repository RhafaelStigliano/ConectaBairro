# UNIVERSIDADE NOVE DE JULHO
## PROJETO PRÁTICO DE PROGRAMAÇÃO
### CONECTABAIRRO — PLATAFORMA INTEGRADA DE APOIO COMUNITÁRIO

**Integrantes:** preencher nome completo e RA de todos os participantes  
**Líder/gerente:** Yasmin Sousa da Silva — RA: preencher/confirmar  
**Curso:** Análise e Desenvolvimento de Sistemas — preencher semestre  
**São Paulo — 2026**

---

## 1. OBJETIVOS

O objetivo geral do ConectaBairro é desenvolver um protótipo de plataforma web para facilitar a comunicação e a colaboração entre moradores do Bairro Uninove, uma comunidade fictícia criada para este projeto.

Como objetivos específicos, pretende-se oferecer um ambiente de acesso por usuário e senha, permitir o registro e acompanhamento de pedidos de ajuda e apresentar áreas destinadas a avisos, eventos e divulgação do comércio local. O projeto busca demonstrar como uma solução digital pode organizar informações e aproximar pessoas de uma comunidade.

### 1.1 DESCRIÇÃO DO SISTEMA

O ConectaBairro é uma plataforma web responsiva destinada a moradores e lideranças comunitárias. O protótipo foi planejado para centralizar informações do bairro e apoiar ações de colaboração. A versão demonstrativa utiliza PHP, MySQL, HTML, CSS e JavaScript.

O sistema possui cadastro e autenticação de usuários e um módulo funcional de pedidos de ajuda, com operações de inclusão, visualização, alteração e exclusão. Também apresenta as áreas de avisos, eventos e comércio local como módulos previstos para evolução.

## 2. DEVOPS

Para organizar o desenvolvimento, a equipe utilizará Git e GitHub para controle de versão e armazenamento do código-fonte. As alterações poderão ser registradas em commits, permitindo acompanhar a evolução do projeto e facilitar o trabalho em equipe. Antes da apresentação, a equipe deverá testar o login e as operações do CRUD em ambiente local.

**Atenção:** descrevam somente as práticas que o grupo realmente executar. Se não utilizarem integração contínua automatizada, não afirmem que possuem pipeline de CI/CD.

## 3. CÓDIGOS DO SISTEMA

Linguagem principal: PHP. Banco de dados: MySQL. O código-fonte deverá ser publicado em um repositório GitHub da equipe.

**Link do GitHub:** inserir o endereço real do repositório após a publicação.

O protótipo permite criar uma conta, realizar login e gerenciar pedidos de ajuda. O usuário pode cadastrar uma solicitação, visualizar os registros, editar seus próprios pedidos e excluí-los mediante confirmação.

## 4. BANCO DE DADOS

O banco de dados `conectabairro` possui cinco tabelas:
- `usuarios`: dados de acesso e perfil.
- `avisos`: comunicados comunitários.
- `pedidos_ajuda`: solicitações de apoio.
- `eventos`: atividades da comunidade.
- `comercios`: negócios e serviços locais.

**Inserir nesta seção o conteúdo integral do arquivo `database.sql` utilizado no projeto.**

## 5. CONCLUSÃO

O desenvolvimento do protótipo ConectaBairro permitiu aplicar conceitos de programação web, banco de dados e operações CRUD em uma situação relacionada à comunidade. A solução demonstra como uma plataforma pode organizar pedidos de ajuda e servir de base para futuras funcionalidades de comunicação, eventos e divulgação de serviços locais.

A equipe deverá ajustar esta conclusão após realizar os testes, registrando somente os resultados efetivamente obtidos.

## 6. REFERÊNCIAS

**PENDENTE:** incluir cinco livros consultados na Biblioteca Digital da Uninove, formatados conforme ABNT, conforme orientação do professor. Acrescentar também documentação e fontes realmente utilizadas no desenvolvimento. Não inventar referências bibliográficas.
