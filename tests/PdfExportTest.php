<?php

declare(strict_types=1);

/**
 * Renders the PDF reports through the real GetReport code path (dompdf) with a
 * small Ukrainian sample and checks that a valid PDF with an embedded Cyrillic
 * capable font comes out. Needs `composer install` to have been run.
 *
 *   php tests/PdfExportTest.php
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

    function assertPdf(bool $condition, string $message): void
    {
        if (!$condition) {
            throw new RuntimeException($message);
        }
    }

    $root = dirname(__DIR__);
    require_once $root . '/vendor/autoload.php';
    require_once $root . '/Lib/DzvinPBXVersion.php';
    require_once $root . '/Lib/GetReport.php';

    $calls = [];
    for ($i = 0; $i < 600; $i++) {
        $calls[] = [
            'typeCallDesc' => 'Вхідний',
            'line' => 'Транк Київстар',
            'DT_RowId' => 'id-' . $i,
            '4' => [[
                'start' => '2026-09-30 10:00:00',
                'src_num' => '380441234567',
                'dst_num' => '201',
                'waitTime' => '00:05',
                'billsec' => '00:42',
                'stateCall' => 'Відповіли',
            ]],
        ];
    }
    $history = (object)[
        'title' => 'Звіт: історія дзвінків',
        'searchPhrase' => json_encode(['dateRangeSelector' => '01.09.2026 - 30.09.2026']),
        'data' => $calls,
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
    $queue = (object)[
        'title' => 'Черги',
        'searchPhrase' => json_encode(['dateRangeSelector' => 'сьогодні']),
        'data' => [[
            'date' => '2026-09-30', 'queueName' => 'Підтримка', 'totalCalls' => 5, 'answered' => 4,
            'missed' => 1, 'answeredQueue' => 4, 'avgWaitTime' => '0:10', 'avgMissed' => '0:20',
            'avgWaitTimeQueue' => '0:12',
        ]],
    ];

    $files = [
        'history' => GetReport::exportHistoryPdf($history, true),
        'employees' => GetReport::exportOutgoingEmployeeCallsPrintPdf($employees, true),
        'queue' => GetReport::exportHistoryQueuePdf($queue, true),
    ];
    foreach ($files as $name => $file) {
        assertPdf(is_file($file) && filesize($file) > 1000, "$name: PDF was not written");
        $head = (string)file_get_contents($file, false, null, 0, 5);
        assertPdf($head === '%PDF-', "$name: not a PDF");
        $pdf = (string)file_get_contents($file);
        assertPdf(str_contains($pdf, 'DejaVu'), "$name: DejaVu font is not embedded");
        echo "$name: $file (" . filesize($file) . " bytes)\n";
    }
    echo "PdfExportTest: OK\n";
}
