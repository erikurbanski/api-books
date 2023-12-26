
# Laravel 9.x - Quick Start (Laravel 9.x + Docker)

Este projeto contém as seguintes tecnologias, especificações e metodologias:

- PHP 8.1+
- Laravel 9.0+
- MySQL
- Docker
- PHPUnit e Mockery
- Composer
- PSR4
- TDD
- SOLID
- Clean Architecture

## Executar o Laravel

Clonar repositório
```sh
git clone https://github.com/erikurbanski/api-books.git api-books
```

Entrar na pasta
```sh
cd api-books/
```

Remova qualquer tipo de arquivo referente a versionamento (opcional)
```sh
rm -rf .git/
```

Crie o arquivo .env baseado no de exemplo .env.example
```sh
cp .env.example .env
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acessar o container *app*
```sh
docker-compose exec app bash
```

Instalar as dependências do projeto
```sh
composer install
```

Gerar a *key* do projeto Laravel
```sh
php artisan key:generate
```

Gerar tabelas no banco de dados MySQL
```sh
php artisan migrate
```

Executar os testes
```sh
./vendor/bin/phpunit 
```
ou
```sh
php artisan test
```
ou
```sh
php artisan test --stop-on-failure
```

Depois basta acessar o projeto em:
<br>
[http://localhost:8000](http://localhost:8888)
<br>

O arquivo Routes_Book_API contido na raiz pode ser importado no Insomnia ou Postman.
O mesmo possibilita testar todas as rotas descritas nesta API.

[Erik Urbanski Santos](http://github.com/erikurbanski)
<br>
Última edição em: 26/12/2023
