<?php

namespace Examples;

use ConsoleLib\Command\CommandInterface;

/**
* Команда приготовления чая с использованием PHP)))
*/
class MakeMeTeaCommand implements CommandInterface
{
   private const TEA_TYPES = [
       'green' => 'Зеленый чай',
       'black' => 'Чёрный чай',
       'rooibos' => 'Ройбуш',
       'hibiscus' => 'Каркаде',
       'herbal' => 'Травяной сбор',
       'oolong' => 'Улун'
   ];

    /**
     * Возвращает имя команды для вызова из консоли
     * @return string
     */
   public function getName(): string
   {
       return 'make-me-tea';
   }

    /**
     * Возвращает описание команды для справки
     * @return string
     */
   public function getDescription(): string
   {
       return 'Команда по приготовлению чая. Аргументы: {количество_чашек}. Параметры: [type=выберите:green, black, rooibos, hibiscus, herbal, oolong], [sugar=количество_кусков], [temp=темпаратура_в_градусах], [lemon=true/false]';
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

       // Обработка аргументов (количество чашек)
       $cups = isset($args[0]) ? (int)$args[0] : 1;   
       $cups = max(1, min(10, $cups)); // Ограничение 1-10 чашек

       // Обработка параметров
       $teaType = $this->validateTeaType($params['type'] ?? 'black');
       $sugar = isset($params['sugar']) ? (int)$params['sugar'] : 2;
       $sugar = max(0, min(10, $sugar)); 
       $temp = isset($params['temp']) ? (int)$params['temp'] : 80;
       $temp = max(60, min(100, $temp));
       $lemon = isset($params['lemon']) && $params['lemon'] === 'true';

       return $this->formatOutput($teaType, $cups, $sugar, $temp, $lemon);
   }

    /**
     * Проверка типа чая на валидность
     * @param string $teaType Тип чая
     * @return string Результат выполнения
     */
   private function validateTeaType(string $teaType): string
   {
       return array_key_exists($teaType, self::TEA_TYPES) ? $teaType : 'black';
   }

    /**
     * Отформатированный вывод результата работы команды
     * @param string $teaType Тип чая
     * @param int $cups Кол-во чашек
     * @param int $sugar Кол-во кусков сахара
     * @param int $temp Температура
     * @param bool $lemon Наличие лимона
     * @return string Результат выполнения
     */
   private function formatOutput(string $teaType, int $cups, int $sugar, int $temp, bool $lemon): string
   {
       $cupsInfo = $cups > 1 ? $cups . ' шт.' : ' ваша 1 чашка';
       $lemonStr = $lemon ? 'с лимоном' : 'без добавок';
       
       return <<<TEA
         )  (
        (   ) )
         ) ( (
       _______)_
    .-'---------|  
   ( C|*********|
    '-.***TEA***|
      '_________'
       '-------'

Ваш чай готов! Пожалуйста, {$cupsInfo}

• Сорт чая: {$this->getTeaName($teaType)}
• Параметры: {$temp}°C, {$sugar} кус. сахара
• Фруктовые добавки: {$lemonStr}

Приятного чаепития и отличного настроения!
TEA;
   }

   /**
     * Получение названия чая на русском языке
     * @param string $teaType Тип чая
     * @return string Результат выполнения
     */
   private function getTeaName(string $teaType): string
   {
       return self::TEA_TYPES[$teaType] ?? 'Чёрный чай';
   }
}