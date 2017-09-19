TrabalheNaMktVirtual-BackEnd
-
[![Build Status](https://travis-ci.org/danilobezerra/Back-End-Test-May.svg?branch=master)](https://travis-ci.org/danilobezerra/Back-End-Test-May)

### Instruções de instalação local

Configurar o backend:

```
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

Atualizar o arquivo .env
```
DB_CONNECTION=sqlite
DB_DATABASE={Caminho local do projeto}/database/database.sqlite
```

Configurar o banco:

```
touch database/database.sqlite
php artisan migrate --seed
```

Configurar o frontend:

```
npm install
npm run dev
```

Iniciar a aplicação em http://localhost:8000
```
php artisan serve
```