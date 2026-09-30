# Модуль розширеної історії дзвінків для Dzvin PBX

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

**Українською** | **[English](README.md)** | **[Русская версия](README.ru.md)**

Модуль розширених записів деталізації дзвінків (CDR) для Dzvin PBX: детальна історія дзвінків з розширеними відборами, звіти, завантаження записів розмов і експорт.

> Це форк модуля MikoPBX **ModuleExtendedCDRs** для Dzvin PBX на основі
> mikopbx/ModuleExtendedCDRs v1.43 - див. розділ [Авторство](#авторство) нижче.

## Можливості

- **Історія дзвінків** з відборами за співробітником, відділом, чергою, провайдером, статусом дзвінка й періодом
- **Звіти** у PDF, XLSX і JSON, зокрема вихідні дзвінки співробітників і вхідні на чергу
- **Звіти за розкладом** з надсиланням на електронну пошту
- **Експорт** записів про дзвінки на довільну HTTP-адресу (вебхуки)
- **Записи розмов** - завантаження окремого запису або архіву записів за вибраними фільтрами
- **Фонова синхронізація** CDR Asterisk у власну базу модуля
- **Багатомовність** - українська, англійська, російська та ще десятки мов

У модулі немає перевірок ліцензії: він вільний і працює без ліцензійного ключа.

## Вимоги

- Dzvin PBX 2024.1.114 або новіша

## Встановлення

1. Відкрийте **Модулі** -> **Маркетплейс** в адмінпанелі Dzvin PBX
2. Знайдіть **Розширена історія дзвінків**
3. Натисніть **Встановити**

Або з релізу на GitHub: завантажте `.zip`, потім **Модулі** -> **Встановлення модуля** і завантажте архів.

## Збірка релізу

```bash
composer install --no-dev
# запакуйте дерево (з vendor/, без .git) у zip з module.json у корені
```

Залежності встановлюються з `composer.json`; `vendor/` у репозиторії не зберігається.

## Сторонні бібліотеки

PDF-звіти формуються бібліотекою [dompdf](https://github.com/dompdf/dompdf) зі шрифтом DejaVu Sans
з її складу (Unicode, підтримує кирилицю). Раніше використовувалась mPDF, яка має ліцензію
GPL-2.0-only і несумісна з GPL-3.0-or-later цього модуля; її більше не застосовують. Усі вбудовані
бібліотеки мають GPL-3.0-сумісні ліцензії (LGPL-бібліотеки можна поєднувати з кодом GPL-3.0):

| Пакет | Призначення | Ліцензія |
|---|---|---|
| `dompdf/dompdf` 3.1.6 | PDF-звіти (замість mPDF) | LGPL-2.1 |
| `dompdf/php-font-lib` 1.0.2 | dompdf: шрифти | LGPL-2.1-or-later |
| `dompdf/php-svg-lib` 1.0.2 | dompdf: SVG | LGPL-3.0-or-later |
| `masterminds/html5` 2.11.0 | dompdf: розбір HTML5 | MIT |
| `sabberworm/php-css-parser` 9.5.0 | dompdf: розбір CSS | MIT |
| `phpoffice/phpspreadsheet` 1.30.6 (+ `markbaker/*`, `maennchen/zipstream-php`, `ezyang/htmlpurifier`, `composer/pcre`, `myclabs/php-enum`, `psr/*`) | XLSX-звіти | MIT (`htmlpurifier`: LGPL-2.1-or-later) |
| `mk-j/php_xlsxwriter` 0.39 | потоковий XLSX | MIT |
| `james-heinrich/getid3` 1.9.23 | теги MP3 | GPL-1.0-or-later / LGPL-3.0-only / MPL-2.0 (використано варіант LGPL-3.0) |
| `monolog/monolog` 2.9.1, `cesargb/php-log-rotation` 2.6.0, `setasign/fpdi` 2.6.8, `symfony/polyfill-mbstring` | журнали та допоміжне | MIT |

## Авторство

Це форк Dzvin PBX модуля [`mikopbx/ModuleExtendedCDRs`](https://github.com/mikopbx/ModuleExtendedCDRs)
(з тегу `v1.43`, коміт `9a4a7e9`), (c) 2017-2024 Alexey Portnov і Nikolay Beketov,
ліцензія GPL-3.0-or-later. У форку простір імен ядра, з яким працює модуль, змінено
(`MikoPBX\` -> `DzvinPBX\`), щоб він працював у Dzvin PBX, прибрано ліцензійні метадані MIKO
(`lic_product_id`, `lic_feature_id`), замінено брендовані зображення MIKO, завершено український
переклад інтерфейсу, змінено посилання й процес випуску під цей репозиторій.
Оригінальні заголовки авторських прав і ліцензії в файлах коду збережено; про АТС, для якої
створювався модуль, див. [MikoPBX Core](https://github.com/mikopbx/Core).
