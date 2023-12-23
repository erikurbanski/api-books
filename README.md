
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
[http://localhost:8888](http://localhost:8888)

Comandos auxiliares e didáticos:

```sh
php artisan make:model Author -m
php artisan make:test App\\Models\CategoryUnitTest --unit
php artisan make:factory AuthorFactory 
php artisan test --filter GetAuthorUseCaseTest
php artisan make:resource AuthorResource
php artisan make:request AuthorResource
php artisan route:list
```
