<?php

namespace App\Events;

use App\SessionToken;

class SessionRefresh
{
    /**
     * Session attributes.
     *
     * @var string
     */
    public $session;

    public function __construct(SessionToken $session)
    {
        $this->session = $session;
    }
}
