<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\SessionToken;

class SessionTransformers extends TransformerAbstract
{
    /**
     * Transform Session.
     *
     * @param Session $session
     */
    public function transform(SessionToken $session)
    {
        return [
            'session_username' => $session->encrypt_username,
            'session_password' => $session->encrypt_password,
            'generated_at' => $session->created_at->toDateTimeString(),
            'lastused_at' => $session->updated_at->toDateTimeString(),
        ];
    }
}