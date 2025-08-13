<?php

namespace ConsoleLib\Input;
/**
 * Парсит аргументы командной строки
 */
class InputParser
{
    /**
     * Разбирает массив аргументов 
     * 
     * @param array $argv Массив аргументов
     * @return Input Объект с разобранными данными
     * 
     */
    public function parse(array $argv): Input
    {
        $commandName = $argv[1] ?? null;
        $args = [];
        $params = [];

        for ($i = 2; $i < count($argv); $i++) {
            $arg = $argv[$i];
            
            // Обработка аргументов в фигурных скобках {arg1,arg2}
            if (str_starts_with($arg, '{') && str_ends_with($arg, '}')) {
                $cleaned = trim($arg, '{}');
                $args = array_merge($args, array_map('trim', explode(',', $cleaned)));
            } 
            // Обработка параметров в квадратных скобках [key=value]
            elseif (str_starts_with($arg, '[') && str_ends_with($arg, ']')) {
                $content = substr($arg, 1, -1); 
                $this->parseParameter($content, $params);
            }
            // Обработка одиночных аргументов без скобок
            else {
                $args[] = trim($arg, '{}');
            }
        }

        return new Input($commandName, $args, $params);
    }

    /**
     * Разбирает параметры
     * 
     * @param string $arg Строка параметра
     * @param array &$params Ссылка на массив параметров
     * @return void
     * 
     */
    private function parseParameter(string $arg, array &$params): void
    {
        $content = trim($arg, '[]');
        $parts = explode('=', $content, 2);
        
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $value = trim($parts[1]);
            
            // Если параметр уже существует (значит Bash разбил его на части)
            if (isset($params[$key])) {
                // Если текущее значение - массив, просто добавляем новое значение
                if (is_array($params[$key])) {
                    // Удаляем фигурные скобки, если есть и разбиваем по запятым
                    $newValues = array_map('trim', explode(',', trim($value, '{}')));
                    $params[$key] = array_merge($params[$key], $newValues);
                } 
                // Если текущее значение - строка, то преобразуем в массив
                else {
                    $params[$key] = [
                        trim($params[$key], '{}'),
                        trim($value, '{}')
                    ];
                }
            }
            // Обычная обработка параметра
            else {
                if (str_starts_with($value, '{') && str_ends_with($value, '}')) {
                    // Обработка массива значений типа {value1,value2}
                    $params[$key] = array_map('trim', 
                        explode(',', trim($value, '{}'))
                    );
                } else {
                    $params[$key] = $value;
                }
            }
        }
    }
}