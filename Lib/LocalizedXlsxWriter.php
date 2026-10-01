<?php
/*
 * Dzvin PBX - free phone system for small business
 * Copyright © 2017-2023 Alexey Portnov and Nikolay Beketov
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <https://www.gnu.org/licenses/>.
 */

namespace Modules\ModuleExtendedCDRs\Lib;

/**
 * XLSXWriter with a localizable page footer.
 *
 * The library writes a fixed English footer ("Page &P") into every sheet;
 * this subclass swaps the sheet writer for one that substitutes the given text.
 */
class LocalizedXlsxWriter extends \XLSXWriter
{
    private string $footerText = '';

    /**
     * Sets the footer text (Excel codes allowed: &P - page number, &N - number of pages).
     */
    public function setFooterText(string $text): void
    {
        $this->footerText = $text;
    }

    public function writeSheetHeader($sheet_name, array $header_types, $col_options = null)
    {
        parent::writeSheetHeader($sheet_name, $header_types, $col_options);
        if ($this->footerText !== '' && isset($this->sheets[$sheet_name])) {
            $sheet = $this->sheets[$sheet_name];
            if (!$sheet->file_writer instanceof XlsxFooterWriter) {
                $sheet->file_writer = new XlsxFooterWriter($sheet->file_writer, $this->footerText);
            }
        }
    }
}
