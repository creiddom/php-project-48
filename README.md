# Gendiff

CLI-утилита и PHP-библиотека для вычисления различий между двумя конфигурационными файлами в формате JSON.

Проект реализован в учебных целях и демонстрирует:

* построение diff между структурами данных,
* работу с CLI,
* автоматическое тестирование,
* линтинг,
* CI и интеграцию с SonarCloud.

---

## Возможности

* Сравнение двух JSON-файлов с плоской структурой (ключ–значение)
* Вывод различий в формате `stylish`
* Использование как CLI-утилиты
* Использование как PHP-библиотеки
* Автоматические тесты (PHPUnit)
* Линтинг кода (PHP CS Fixer)
* CI через GitHub Actions
* Анализ качества и покрытия кода через SonarCloud

---

## Пример использования (CLI)

```bash
gendiff file1.json file2.json
```

Пример вывода:

```text
{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}
```

---

## Использование как библиотеки

```php
<?php

use function Differ\Differ\genDiff;

$result = genDiff($pathToFile1, $pathToFile2);
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

<!-- GitHub Actions -->

[![CI](https://github.com/creiddom/php-project-48/actions/workflows/ci.yml/badge.svg)](https://github.com/creiddom/php-project-48/actions/workflows/ci.yml)

<!-- SonarCloud -->

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=creiddom_php-project-48&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=creiddom_php-project-48)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=creiddom_php-project-48&metric=coverage)](https://sonarcloud.io/summary/new_code?id=creiddom_php-project-48)

---

## Требования

* PHP >= 8.2
* Composer

---

## Лицензия

Proprietary

### Hexlet tests and linter status:
[![Actions Status](https://github.com/creiddom/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/creiddom/php-project-48/actions)
