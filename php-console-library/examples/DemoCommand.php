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
        // Вывод описания по команде, если агрумент = help
       if (isset($args[0]) && $args[0] == "help") {
        return $this->getDescription();
       }
       else {
            $output = "Запуск команды demo: \n";
            
            if (!empty($args)) {
                $output .= "Аргументы: \n\t- " . implode(" \n\t- ", $args) . "\n\n";
            }
            
            if (!empty($params)) {
                $outputParams = $this->printParams($params,1);
            }

            $output .= "Параметры: \n" . $outputParams;
            return $output;
        }       
    }

    /**
     * Форматирует массив параметров в строку для вывода на экран с отступами
     * 
     * @param array $params Массив параметров
     * @param int $indent Начальный уровень отступа в кол-ве табов
     * @return string Форматированная строка
     */
    private function printParams(array $params, int $indent = 0): string
    {
        $result = '';
        $tab = str_repeat("\t", $indent);
    
        foreach ($params as $key => $value) {
            // Не печатаем цифровые индексы в конечном уровне вложенности массива
            if (is_int($key)) {
                if (is_array($value)) {
                    $result .= $this->printParams($value, $indent);
                } else {
                    $result .= "{$tab}- {$value}\n";
                }
            } 
            // Для ассоциативных элементов массива
            else {
                $result .= "{$tab}- {$key}:\n";
                if (is_array($value)) {
                    $result .= $this->printParams($value, $indent + 1);
                } else {
                    $valueTab = str_repeat("\t", $indent + 1);
                    $formattedValue = is_bool($value) 
                        ? ($value ? 'true' : 'false') 
                        : $value;
                    $result .= "{$valueTab}- {$formattedValue}\n";
                }
            }
        }        
        return $result;
    }
}