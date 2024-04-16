[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-24ddc0f5d75046c5622901739e7c5dd533143b0c8e959d652212380cedb1ea36.svg)](https://classroom.github.com/a/nNlp9fKx)
# Cod'Flix project

## Setup
1. You have to use a local server such as [Wamp](https://wampserver.com/) or [Mamp](https://www.mamp.info/)
1. Pull the repo in the `www/` directory of your local server
1. Import `codflix.sql` in your database
1. Follow the address of your repo. For example, if your repo is in ``www/codflix/``, the URL should be http://127.0.0.1/codflix

## Database
You can configure your database access in the file `model/database.php`. Simply update the default values in the `init_db()` function:
```php
$host = $_ENV['CODFLIX_DB_HOST'] ?? 'localhost';
$dbname = $_ENV['CODFLIX_DB_NAME'] ?? 'codflix';
$charset = $_ENV['CODFLIX_DB_CHARSET'] ?? 'utf8';
$user = $_ENV['CODFLIX_DB_USER'] ?? 'root';
$password = $_ENV['CODFLIX_DB_PASSWORD'] ?? '';
```

For example, if you want to change the database password with `"mypassword"`, update the `$password` variable:

```php
$password = $_ENV['CODFLIX_DB_PASSWORD'] ?? 'mypassword'; // just update at the right side of the ??
```
