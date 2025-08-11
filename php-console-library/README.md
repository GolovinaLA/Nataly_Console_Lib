# Консольная библиотека для PHP

Библиотека для создания консольных команд.

## Установка

1. Клонируйте репозиторий:
```bash
git clone https://github.com/GolovinaLA/Nataly_Console_Lib
cd console-lib

Установите зависимости через Composer:

bash
composer install

Примеры команд
См. файл TESTS.md

Создание новых команд
Создайте новый класс в папке src/examples:

php
namespace Examples;
use ConsoleLib\Command\CommandInterface;

class NewCommand implements CommandInterface
{
    public function getName(): string
    {
        return 'new-command';
    }
    
    public function getDescription(): string
    {
        return 'Описание вашей команды';
    }
    
    public function execute(array $args, array $params): string
    {
        // Логика команды
        return 'Результат выполнения';
    }
}

Зарегистрируйте команду в  bin/console
php
$app->registerCommand(new NewCommand());

Соберите Docker-образ:
bash
docker-compose build

Проверьте работу:
bash
docker-compose run --rm console new-command

Лицензия
MIT