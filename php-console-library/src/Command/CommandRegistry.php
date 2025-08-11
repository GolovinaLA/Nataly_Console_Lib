<?php

namespace ConsoleLib\Command;

/**
 * Реестр для хранения и управления командами
 */
class CommandRegistry {
    /** @var array<CommandInterface> */
    private array $commands = [];

    /**
     * Регистрирует новую команду
     * 
     * @param CommandInterface $command Экземпляр команды
     * @return void
     */
    public function register(CommandInterface $command): void {
        
        $this->validateCommand($command);
        $this->commands[$command->getName()] = $command;
        
    }
    
    /**
     * Валидирует команду
     * @param object $command
     * @throws InvalidArgumentException
     */
    public function validateCommand($command): void{
        if (!$command instanceof CommandInterface) {
            throw new InvalidArgumentException(
                'Команда должна реализовывать интерфейс ' . CommandInterface::class
            );
        }
    }

    /**
     * Возвращает команду по имени
     * 
     * @param string $name Имя команды
     * @return CommandInterface|null Возвращает команду или null, если она не найдена
     */
    public function getCommand(string $name): ?CommandInterface {
        return $this->commands[$name] ?? null;
    }

    /**
     * Возвращает все зарегистрированные команды
     * 
     * @return array<CommandInterface>
     */
    public function getAllCommands(): array {
        return $this->commands;
    }
}