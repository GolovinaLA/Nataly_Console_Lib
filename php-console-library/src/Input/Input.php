<?php

namespace ConsoleLib\Input;

/**
 * Объект ввода команды, содержащий разобранные аргументы и параметры
 * 
 * Обрабатыва данные, полученные из командной строки, после их парсинга.
 * Предоставляет безопасный доступ к аргументам и параметрам команды.
 */
class Input
{
    /**
     * @var string|null Имя команды
     */
    private ?string $commandName;

    /**
     * @var array Аргументы команды
     */
    private array $args;

    /**
     * @var array Параметры команды (ключ-значение)
     */
    private array $params;

    /**
     * Конструктор объекта ввода
     *
     * @param string|null $commandName Имя команды
     * @param array $args Массив аргументов
     * @param array $params Массив параметров
     */
    public function __construct(?string $commandName, array $args = [], array $params = [])
    {
        $this->commandName = $commandName;
        $this->args = $args;
        $this->params = $params;
    }

    /**
     * Возвращает имя команды
     *
     * @return string|null
     */
    public function getCommandName(): ?string
    {
        return $this->commandName;
    }

    /**
     * Возвращает аргументы команды
     *
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * Возвращает параметры команды
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Проверяет наличие аргумента
     *
     * @param string $argName Имя аргумента
     * @return bool
     */
    public function hasArg(string $argName): bool
    {
        return in_array($argName, $this->args, true);
    }

    /**
     * Проверяет наличие параметра
     *
     * @param string $paramName Имя параметра
     * @return bool
     */
    public function hasParam(string $paramName): bool
    {
        return array_key_exists($paramName, $this->params);
    }

    /**
     * Возвращает значение параметра или значение по умолчанию
     *
     * @param string $paramName Имя параметра
     * @param mixed $default Значение по умолчанию
     * @return mixed
     */
    public function getParam(string $paramName, $default = null)
    {
        return $this->params[$paramName] ?? $default;
    }
}