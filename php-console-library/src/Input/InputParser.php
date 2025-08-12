<?php

namespace ConsoleLib\Input;
/**
 * Парсит аргументы командной строки
 */
class InputParser
{
    /**
     * Разбирает массив аргументов {arg}
     * 
     * @param array $argv Массив аргументов (обычно $_SERVER['argv'])
     * @return Input Объект с разобранными данными
     * 
     */
    public function parse(array $argv): Input
    {
        $commandName = $argv[1] ?? null;
        $args = [];
        $params = [];
        $args = [];

        for ($i = 2; $i < count($argv); $i++) {

            $arg = $argv[$i];
        
            if (str_starts_with($arg, '{') && str_ends_with($arg, '}')) {

                $args = array_merge($args, preg_split('/[{} ,]/', $arg, -1, PREG_SPLIT_NO_EMPTY));
            } 
            elseif (str_starts_with($arg, '[') && str_ends_with($arg, ']')) {
                $content = substr($arg, 1, -1); // Удаляем внешние скобки
                $this->parseParameter($content, $params);
            }
                else {
                    $args[] = str_replace(['{', '}'], '', $arg);
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
