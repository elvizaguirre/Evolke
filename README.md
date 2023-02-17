# POC Volk LMS

Desafio EVOLKE

### Prerequisites

PHP 7.4
Composer
MySQL Server


### Installing

Instalar dependências via Composer

    ~$composer install

Definir os parâmetros principais em config.php

    define('DB_HOST','localhost');
    define('DB_NAME','evolke');
    define('DB_PORT','3306');
    define('DB_USER','root');
    define('DB_PASSWD','');

Criar o banco de dados configurado

Executar migrações
    ~$vendor/bin/phinx migrate

Pronto! O sistema deve estar funcionando

## Running the tests

./vendor/bin/phpunit --verbose test

## Authors

  - **Eduardo Valdés** - elvizaguirre89@gmail.com