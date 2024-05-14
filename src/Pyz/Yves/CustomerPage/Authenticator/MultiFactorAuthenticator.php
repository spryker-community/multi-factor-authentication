<?php

namespace Pyz\Yves\CustomerPage\Authenticator;

use SprykerShop\Yves\CustomerPage\Authenticator\CustomerLoginFormAuthenticator as SprykerCustomerLoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class MultiFactorAuthenticator implements AuthenticatorInterface, AuthenticationEntryPointInterface
{

    public function start(Request $request, ?AuthenticationException $authException = null)
    {
        // TODO: Implement start() method.
    }

    public function supports(Request $request): ?bool
    {
        return false;
    }

    public function authenticate(Request $request): Passport
    {
        // TODO: Implement authenticate() method.
    }

    public function createToken(Passport $passport, string $firewallName): TokenInterface
    {
        // TODO: Implement createToken() method.
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // TODO: Implement onAuthenticationSuccess() method.
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // TODO: Implement onAuthenticationFailure() method.
    }
}
