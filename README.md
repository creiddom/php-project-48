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
* Использование как CLI-утилиты
* Использование как PHP-библиотеки
* Автоматические тесты (PHPUnit)
* Линтинг кода (PHP CS Fixer)
* CI через GitHub Actions
* Анализ качества и покрытия кода через SonarCloud

---

## Пример использования (CLI)

### Справка

```bash
php bin/gendiff -h
```

### Сравнение файлов

```bash
php bin/gendiff file1.json file2.json
```

По умолчанию используется формат `stylish`.

### Указание формата вывода

```bash
php bin/gendiff -f stylish file1.json file2.json
```

или

```bash
php bin/gendiff --format stylish file1.json file2.json
```

---

## Пример вывода

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

---

## Demo

Пример работы утилиты (CLI):

[https://asciinema.org/a/oE7yjPaON1WTIHtoGazFBgrT9](https://asciinema.org/a/oE7yjPaON1WTIHtoGazFBgrT9)

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
