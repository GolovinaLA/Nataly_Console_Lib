<?php

namespace Examples;

use ConsoleLib\Command\CommandInterface;

/**
 * Демонстрационная команда для тестирования аргументов и параметров
 */
class DemoCommand implements CommandInterface
{
    /**
     * Возвращает имя команды для вызова из консоли
     * @return string
     */
    public function getName(): string
    {
        return 'demo';
    }

    /**
     * Возвращает описание команды для справки
     * @return string
     */
    public function getDescription(): string
    {
        return 'Команда вывода введенных агрументов и параметров. Аргументы: {arg1, arg2, ... }. Параметры: [name=value]';
    }

    /**
     * Выполняет команду с обработкой аргументов
     * @param array $args Массив аргументов
     * @param array $params Ассоциативный массив параметров
     * @return string Результат выполнения
     */
    public function execute(array $args, array $params): string
    {
        // Вывод описание по команде, если агрумент = help
       if (isset($args[0]) && $args[0] == "help") {
        return $this->getDescription();
       }
       else {
            $output = "Запуск команды:\n";
            
            if (!empty($args)) {
                $output .= "Аргументы: " . implode(', ', $args) . "\n";
            }
            
            if (!empty($params)) {
                $output .= "Параметры:\n";
                foreach ($params as $name => $value) {
                    $valueStr = is_array($value) ? implode(', ', $value) : $value;
                    $output .= "  $name: $valueStr\n";
                }
            }
            return $output;
        }
    }
}