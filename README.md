# Gendiff

CLI-утилита и PHP-библиотека для вычисления различий между двумя конфигурационными файлами.

Проект реализован в учебных целях и демонстрирует:

* построение diff между структурами данных,
* работу с CLI,
* рекурсивное сравнение вложенных структур,
* автоматическое тестирование,
* линтинг,
* CI и интеграцию с SonarCloud.

---

## Возможности

* Сравнение двух конфигурационных файлов
* Поддержка вложенных структур
* Поддерживаемые форматы:
  * JSON (`.json`)
  * YAML (`.yml`, `.yaml`)
* Вывод различий в формате `stylish`
* Вывод различий в формате `plain`
* Использование как CLI-утилиты
* Использование как PHP-библиотеки

---

## Пример использования (CLI)

### Справка

```bash
php bin/gendiff -h
```

### Сравнение файлов (формат по умолчанию — stylish)

```bash
php bin/gendiff file1.json file2.json
```

### Указание формата вывода

```bash
php bin/gendiff -f plain file1.json file2.json
```

или

```bash
php bin/gendiff --format plain file1.json file2.json
```

---

## Пример вывода (stylish)

```text
{
    common: {
      + follow: false
        setting1: Value 1
      - setting2: 200
      - setting3: true
      + setting3: null
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
        setting6: {
            doge: {
              - wow:
              + wow: so much
            }
            key: value
          + ops: vops
        }
    }
    group1: {
      - baz: bas
      + baz: bars
        foo: bar
      - nest: {
            key: value
        }
      + nest: str
    }
  - group2: {
        abc: 12345
        deep: {
            id: 45
        }
    }
  + group3: {
        deep: {
            id: {
                number: 45
            }
        }
        fee: 100500
    }
}
```
## Пример вывода (plain)
```text
Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From true to null
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' was updated. From 'bas' to 'bars'
Property 'group1.nest' was updated. From [complex value] to 'str'
Property 'group2' was removed
Property 'group3' was added with value: [complex value]
```
---

## Demo

Пример работы утилиты (CLI):

https://asciinema.org/a/limHv3yV5I878pvAUhqpcudQh

---

## Использование как библиотеки

```php
<?php

use function Differ\\Differ\\genDiff;

$result = genDiff($pathToFile1, $pathToFile2, 'stylish');
echo $result;
```

---

## Установка

```bash
composer install
```

---

## Команды разработки

### Линтер

Проверка стиля кода:

```bash
make lint
```

Автоматическое исправление:

```bash
make lint-fix
```

### Тесты

```bash
make test
```

### Тесты с покрытием

```bash
make test-coverage
```

Отчёт о покрытии генерируется в файле:

```text
build/logs/clover.xml
```

---

## Тестирование

Для тестирования используется **PHPUnit**.

Фикстуры располагаются в директории:

```text
tests/fixtures
```

---

## CI и качество кода

Проект использует **GitHub Actions** для:

* установки зависимостей,
* запуска линтера,
* запуска тестов,
* генерации покрытия кода,
* отправки отчёта покрытия в SonarCloud.

Анализ качества кода и покрытия выполняется через **SonarCloud**.

---

## Бейджи

[![CI](https://github.com/creiddom/php-project-48/actions/workflows/ci.yml/badge.svg)](https://github.com/creiddom/php-project-48/actions/workflows/ci.yml)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=creiddom_php-project-48\&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=creiddom_php-project-48)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=creiddom_php-project-48\&metric=coverage)](https://sonarcloud.io/summary/new_code?id=creiddom_php-project-48)

---

## Требования

* PHP >= 8.2
* Composer

---

## Лицензия

Proprietary

### Hexlet tests and linter status:

[![Actions Status](https://github.com/creiddom/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/creiddom/php-project-48/actions)
