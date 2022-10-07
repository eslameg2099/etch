<?php

namespace App\Support\Payment\Contracts;

interface TransactionStatuses
{
    /**
     * The code of balance status.
     *
     * @var int
     */
    const BALANCE_STATUS = 1;

    /**
     * The code of hold status.
     *
     * @var int
     */
    const PENDING_STATUS = 2;

    /**
     * The code of hold status.
     *
     * @var int
     */
    const HOLED_STATUS = 3;

    /**
     * The code of rejected status.
     *
     * @var int
     */
    const REJECTED_STATUS = 4;

    /**
     * The code of withdrawal request status.
     *
     * @var int
     */
    const WITHDRAWAL_REQUEST_STATUS = 5;

    /**
     * The code of withdrawal status.
     *
     * @var int
     */
    const WITHDRAWAL_STATUS = 6;
}