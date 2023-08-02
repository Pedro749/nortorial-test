# Teste Nortorial

## Introdução

Este foi um projeto desenvolvido, para teste de habilidades para a empresa Nortorial, o sistema consiste no cadastro, edição e listagem de clientes e protocolos, além da possibilidade da impressão dos protocolos, juntamente com um sistema de criação de usuário e sistema de login.

## Requer

- PHP 7
- Composer 1
- MYSQL

## Instalação
  
Para rodar este projeto, você precisará de um servidor MYSQL ativo, onde irá popular com o banco de dados e tabelas que estão disponiveis  em ```data/zf3_nortorial.sql```.

Agora você deve configurar as credenciais do banco de dados dentro dos arquivos, um exemplo de uso, está disponível em ```config/autoload/global.php```.

Posteriormente será necessário instalar os pacotes utilizados no projeto com o composer na versão 1, para fazer isso, você pode instalar o composer na sua máquina, ou então executar com o php, composer.phar, este está localizado em ```data/composer.phar```.

Após isso, basta configurar um servidor apache com raiz em public do projeto, ou basta usar o comando ```composer serve```, ou ```php data/composer.phar serve```, para que seja criado um servidor localhost:8080 com o php, e pronto.
