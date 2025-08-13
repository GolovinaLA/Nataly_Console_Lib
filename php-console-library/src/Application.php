<?php

namespace ConsoleLib;

use ConsoleLib\Command\CommandInterface;
use ConsoleLib\Command\CommandRegistry;
use ConsoleLib\Input\InputParser;
use InvalidArgumentException;

/**
 * Основной класс приложения для управления консольными командами
 */
class Application
{
     /**
     * @var CommandRegistry Реестр зарегистрированных команд
     */
    private CommandRegistry $commandRegistry;
     /**
     * @var InputParser Парсер входных аргументов командной строки
     */
    private InputParser $inputParser;
    
    /**
     * Конструктор приложения
     * Инициализирует реестр команд и парсер аргументов
     */
    public function __construct()
    {
        $this->commandRegistry = new CommandRegistry();
        $this->inputParser = new InputParser();
    }

    /**
     * Регистрирует новую команду в приложении
     * 
     * @param object $command Объект команды для регистрации
     * @throws InvalidArgumentException Если команда не реализует CommandInterface
     */
    public function registerCommand(object $command): void
    {
        $this->commandRegistry->register($command);
    }

    /**
     * Запускает приложение и выполняет введенную пользователем команду
     * 
     * @param array $argv Аргументы командной строки
     */
    public function run(array $argv): void
    {
        try {
            $input = $this->inputParser->parse($argv);
            
            if ($input->getCommandName() === null) {
                $this->showHelp();
                return;
            }

            $command = $this->commandRegistry->getCommand($input->getCommandName());
            if ($command === null) {
                throw new InvalidArgumentException("Такая команда не найдена в реестре.");
            }

            $result = $command->execute($input->getArgs(), $input->getParams());
            echo $result;
            
        } catch (InvalidArgumentException $e) {
            echo "Ошибка: " . $e->getMessage() . "\n";
            $this->showHelp();
        }
    }

    /**
     * Выводит справочную информацию о зарегистрированных командах
     */
    private function showHelp(): void
    {
        echo "Список доступных команд:\n";
        foreach ($this->commandRegistry->getAllCommands() as $command) {
            echo sprintf("  %-15s %s\n", 
                $command->getName(), 
                $command->getDescription()
            );
        }
        echo "\nПример использования: command {args} [params]\n";
    }
}