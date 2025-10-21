# Candidaturas

Este projeto é uma API para gerenciamento de candidaturas, empresas, cidades, categorias, modalidades, contratos e status.

## Requisitos

-   PHP 8.2
-   composer 2.8.10
-   MySQL## Instalação
    Clone o repositório:

```bash
git clone https://github.com/AllanPessin/candidaturas.git
```

Configure o arquivo .env com as suas credenciais de banco de dados e outras configurações.

```bash
cp .env.examlpe .env
```

Instale as dependências do Composer:

```bash
componser install
```

Configure o projeto

```bash
php artisan key:generate
```

Execute as migrações do banco de dados.(Opcional) Popule o banco de dados com dados de exemplo comando `--seed`:

```bash
php artisan migrate --seed
```

Inicie o servidor Laravel:

```bash
php artisan serve
```

## Variáveis de Ambiente

Para rodar esse projeto, você vai precisar adicionar as seguintes variáveis de ambiente no seu .env

`APP_URL`

`DB_DATABASE`
`DB_USERNAME`
`DB_PASSWORD`

## Referência

-   [Laravel](https://laravel.com)
-   [MySQL](https://www.mysql.com/)
-   [Swagger](https://swagger.io/)

## Licença

Software de código aberto licenciado sob a [MIT license](https://choosealicense.com/licenses/mit/)
