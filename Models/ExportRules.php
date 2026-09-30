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

class ExportRules extends ModulesModelsBase
{

    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * Список ID пользователей через запятую.
     * @Column(type="string", default="", nullable=true)
     */
    public $users;

    /**
     * Наименование роли.
     * @Column(type="string", default="", nullable=true)
     */
    public $name;

    /**
     * Список ID пользователей через запятую.
     * @Column(type="string", default="", nullable=true)
     */
    public $dstUrl;

    /**
     * Дополнительные заголовки
     * @Column(type="string", default="", nullable=true)
     */
    public $headers;

    public function initialize(): void
    {
        $this->setSource('m_ExportRules');
        parent::initialize();
    }
}