<?php
/**
 * Copyright © MIKO LLC
 * Licensed under the GNU General Public License v3.0 or later;
 * see the LICENSE file in the root of this repository.
 * Written by Alexey Portnov, 2 2019
 */

/*
 * https://docs.phalcon.io/4.0/en/db-models
 *
 */

namespace Modules\ModuleExtendedCDRs\Models;

use DzvinPBX\Modules\Models\ModulesModelsBase;

/**
 * @package Modules\ExportResults\Models
 * @Indexes(
 *     [name='cdrId', columns=['cdrId'], type=''],
 *     [name='result', columns=['result'], type='']
 * )
 */
class ExportResults extends ModulesModelsBase
{

    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * id строки cdr.
     * @Column(type="string", default="", nullable=true)
     */
    public $cdrId;

    /**
     * Имя файла для выгрузки на сервер.
     * @Column(type="string", default="", nullable=true)
     */
    public $resFilename;

    /**
     * Полный путь к исходному файлу.
     * @Column(type="string", default="", nullable=true)
     */
    public $srcFilename;

    /**
     * Результат
     * @Column(type="integer", default="0", nullable=true)
     */
    public $result = 0;

    public function initialize(): void
    {
        $this->setSource('m_ExportResults');
        parent::initialize();
    }
}