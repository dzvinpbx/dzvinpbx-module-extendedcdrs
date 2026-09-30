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
use DzvinPBX\Common\Models\ModelsBase;
use Modules\ModuleExtendedCDRs\Lib\Providers\CdrDbProvider;

/**
 * Class CallDetailRecords
 *
 * @package DzvinPBX\Common\Models
 *
 * @Indexes(
 *     [name='date', columns=['date'], type=''],
 *     [name='queueId', columns=['queueId'], type=''],
 *     [name='linkedid', columns=['linkedid'], type='']
 * )
 */
class CallQueuesHistory extends ModelsBase
{

    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * Time when the call starts.
     * @Column(type="string", nullable=true)
     */
    public ?string $date = '';

    /**
     * Time when the call starts.
     * @Column(type="string", nullable=true)
     */
    public ?string $time = '';

    /**
     * Time when the call ends.
     * @Column(type="string", nullable=true)
     */
    public ?string $queueId = '';

    /**
     * @Column(type="integer", nullable=true)
     */
    public ?string $answered = '0';
    /**
     * @Column(type="integer", nullable=true)
     */
    public ?string $answeredQueue = '0';

    /**
     * @Column(type="integer", nullable=true)
     */
    public ?string $waitTime = '0';

    /**
     * @Column(type="integer", nullable=true)
     */
    public ?string $waitTimeQueue = '0';

    /**
     * Linked ID of the call.
     *
     * @Column(type="string", nullable=true)
     */
    public ?string $linkedid = '';

    public function initialize(): void
    {
        $this->setSource('cdr_queue');
        parent::initialize();
        $this->useDynamicUpdate(true);
        if(!$this->di->has(CdrDbProvider::SERVICE_NAME)){
            $this->di->register(new CdrDbProvider());
        }
        $this->setConnectionService(CdrDbProvider::SERVICE_NAME);
    }

}