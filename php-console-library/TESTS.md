### Проверка списка команд
docker-compose run --rm console

# Вызов справки
docker-compose run --rm console make-me-tea {help}
docker-compose run --rm console demo {help}

## Тестирование команды make-me-tea
### Базовые сценарии

# Минимальный вызов (1 чашка чёрного чая)
docker-compose run --rm console make-me-tea

# Указание количества чашек
docker-compose run --rm console make-me-tea {3}
Тестирование типов чая

# Зелёный чай
docker-compose run --rm console make-me-tea [type=green]

# Ройбуш
docker-compose run --rm console make-me-tea [type=rooibos]

# Несуществующий тип (должен вернуть чёрный)
docker-compose run --rm console make-me-tea [type=unknown]
Тестирование параметров

# Сахар
docker-compose run --rm console make-me-tea [sugar=5]

# Температура
docker-compose run --rm console make-me-tea [temp=90]

# Лимон
docker-compose run --rm console make-me-tea [lemon=true]

# Комбинация параметров
docker-compose run --rm console make-me-tea [type=hibiscus] [sugar=3] [temp=70] [lemon=true]

### Комбинированные тесты

# 2 чашки улуна с 1 куском сахара
docker-compose run --rm console make-me-tea {2} [type=oolong] [sugar=1]

# 5 чашек травяного с лимоном
docker-compose run --rm console make-me-tea {5} [type=herbal] [lemon=true]

# Максимальные значения
docker-compose run --rm console make-me-tea {10} [type=black] [sugar=10] [temp=100]

### Граничные случаи

# Некорректное количество чашек (должно быть 1-10)
docker-compose run --rm console make-me-tea {0}
docker-compose run --rm console make-me-tea {15}

# Некорректные параметры
docker-compose run --rm console make-me-tea [sugar=-5]
docker-compose run --rm console make-me-tea [temp=50]
docker-compose run --rm console make-me-tea [lemon=maybe]
Производительность

# Тест с максимальным количеством параметров
docker-compose run --rm console make-me-tea {10} [type=green] [sugar=10] [temp=100] [lemon=true]

docker-compose run --rm console make-me-tea {3} \
  [type=green] \
  [sugar=2] \
  [temp=85] \
  [lemon=true]
Примечание: Для всех команд с параметром lemon значение должно быть строго true или false (регистр не важен). Все остальные значения будут интерпретированы как false.

## Тестирование demo команды

# Одиночный аргумент
docker-compose run --rm console demo {test}

# Несколько аргументов в одной группе
docker-compose run --rm console demo {arg1,arg2,arg3}

# Раздельные группы аргументов
docker-compose run --rm console demo {arg1} {arg2} {arg3}

# Смешанный формат
docker-compose run --rm console demo {arg1,arg2} {arg3}

# Простой параметр
docker-compose run --rm console demo [param=value]

# Параметр с несколькими значениями
docker-compose run --rm console demo [params={v1,v2,v3}]

# Несколько параметров
docker-compose run --rm console demo [p1=1] [p2=2] [p3=3]

# Аргументы + параметры
docker-compose run --rm console demo {arg} [param=value]

