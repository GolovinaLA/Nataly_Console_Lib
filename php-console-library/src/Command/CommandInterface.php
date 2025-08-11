<?php

namespace ConsoleLib\Command;

/**
 * Интерфейс для консольных команд
 */
interface CommandInterface {
    /**
     * Возвращает имя команды, которое используется для вызова из консоли
     * 
     * @return string
     */
    public function getName(): string;

    /**
     * Возвращает описание команды для вывода в справке
     * 
     * @return string
     */
    public function getDescription(): string;

    /**
     * Выполняет логику команды
     * 
     * @param array $args Массив аргументов
     * @param array $params Массив параметров
     * @return void
     */
    public function execute(array $args, array $params): string; 
}