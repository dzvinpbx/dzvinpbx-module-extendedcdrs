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
 * Proxy for the sheet writer of XLSXWriter that replaces the hard-coded English
 * page footer ("Page &P") with a localized one while the sheet XML is streamed.
 */
class XlsxFooterWriter
{
    private const DEFAULT_FOOTER = 'Page &amp;P';

    /** @var object */
    private $inner;

    private string $footerXml;

    /**
     * @param object $inner  the original XLSXWriter_BuffererWriter
     * @param string $footer footer text with Excel codes, e.g. "Page &P of &N"
     */
    public function __construct($inner, string $footer)
    {
        $this->inner = $inner;
        $this->footerXml = htmlspecialchars($footer, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    public function write($string): void
    {
        if (strpos((string)$string, self::DEFAULT_FOOTER) !== false) {
            $string = str_replace(self::DEFAULT_FOOTER, $this->footerXml, (string)$string);
        }
        $this->inner->write($string);
    }

    public function __call(string $name, array $arguments)
    {
        return $this->inner->$name(...$arguments);
    }
}
