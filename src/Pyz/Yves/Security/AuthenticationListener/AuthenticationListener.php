<?php

namespace Pyz\Yves\Security\AuthenticationListener;

use Spryker\Yves\Security\AuthenticationListener\AuthenticationListener as SprykerAuthenticationListener;

class AuthenticationListener extends SprykerAuthenticationListener
{
    protected const DEFAULT_AUTHENTICATION_LISTENER_FACTORY_TYPES = [
        'logout',
        'pre_auth',
        'form',
        'http',
        'customer_session_validator',
        'multi_factor',
    ];
}
