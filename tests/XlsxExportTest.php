<?php

declare(strict_types=1);

/**
 * Writes the XLSX reports to a file through the real GetReport code path
 * (the same one the scheduled e-mail uses) with a Ukrainian sample and checks
 * that a valid workbook with the Cyrillic text comes out. Needs `composer install`.
 *
 *   php tests/XlsxExportTest.php
 */

namespace Phalcon {
    if (!class_exists(Di::class)) {
        class Di
        {
            public static function getDefault()
            {
                return null;
            }
        }
    }
}

namespace DzvinPBX\Core\System {
    if (!class_exists(Util::class)) {
        class Util
        {
            public static function translate(string $key): string
            {
                return 'Колонка ' . $key;
            }

            public static function mwMkdir(string $dir, bool $recursive = false): void
            {
                @mkdir($dir, 0777, $recursive);
            }
        }
    }
}

namespace {
    use Modules\ModuleExtendedCDRs\Lib\GetReport;

    function assertXlsx(bool $condition, string $message): void
    {
        if (!$condition) {
            throw new RuntimeException($message);
        }
    }

    function xlsxContains(string $file, string $needle): bool
    {
        $zip = new ZipArchive();
        assertXlsx($zip->open($file) === true, "$file is not a zip archive");
        assertXlsx($zip->locateName('xl/workbook.xml') !== false, "$file has no xl/workbook.xml");
        $found = false;
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = (string)$zip->getNameIndex($i);
            if (str_starts_with($name, 'xl/') && str_contains((string)$zip->getFromIndex($i), $needle)) {
                $found = true;
                break;
            }
        }
        $zip->close();
        return $found;
    }

    $root = dirname(__DIR__);
    require_once $root . '/vendor/autoload.php';
    require_once $root . '/Lib/DzvinPBXVersion.php';
    require_once $root . '/Lib/GetReport.php';

    $history = (object)[
        'title' => 'Звіт: історія дзвінків',
        'searchPhrase' => json_encode(['dateRangeSelector' => '01.09.2026 - 30.09.2026']),
        'data' => [[
            'typeCallDesc' => 'Вхідний',
            'line' => 'Транк Київстар',
            'DT_RowId' => 'id-1',
            '4' => [[
                'start' => '2026-09-30 10:00:00',
                'src_num' => '380441234567',
                'dst_num' => '201',
                'waitTime' => '00:05',
                'billsec' => '00:42',
                'stateCall' => 'Відповіли',
            ]],
        ]],
    ];
    $employees = (object)[
        'title' => 'Вихідні дзвінки співробітників',
        'searchPhrase' => json_encode(['dateRangeSelector' => 'вересень']),
        'data' => [[
            'callerId' => 'Іваненко Їжак Єва',
            'number' => '201',
            'billHourCalls' => 1,
            'billMinCalls' => 2,
            'billSecCalls' => 3,
            'countCalls' => 4,
        ]],
    ];

    $cases = [
        'history' => [GetReport::exportHistoryXls($history, true), 'Транк Київстар'],
        'employees' => [GetReport::exportOutgoingEmployeeCallsPrintXls($employees, true), 'Іваненко Їжак Єва'],
    ];
    foreach ($cases as $name => [$file, $needle]) {
        assertXlsx(str_ends_with($file, '.xlsx'), "$name: returned path must end with .xlsx");
        assertXlsx(is_file($file) && filesize($file) > 500, "$name: XLSX was not written to $file");
        assertXlsx(xlsxContains($file, $needle), "$name: Ukrainian text is missing from the workbook");
        echo "$name: $file (" . filesize($file) . " bytes)\n";
        unlink($file);
    }
    echo "XlsxExportTest: OK\n";
}
