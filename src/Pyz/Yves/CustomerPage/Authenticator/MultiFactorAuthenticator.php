<?php

namespace Pyz\Yves\CustomerPage\Authenticator;

use Spryker\Yves\Router\Router\ChainRouter;
use SprykerShop\Yves\CustomerPage\Plugin\Security\CustomerPageSecurityPlugin;
use SprykerShop\Yves\CustomerPage\Security\Customer;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class MultiFactorAuthenticator implements AuthenticatorInterface, AuthenticationEntryPointInterface
{

    private const PARAMETER_MULTI_FACTOR_FORM = 'confirmSecondFactorForm';

    protected TokenStorageInterface $tokenStorage;

    protected ChainRouter $router;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        ChainRouter           $router
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    public function start(Request $request, ?AuthenticationException $authException = null): RedirectResponse
    {
        return new RedirectResponse($this->router->generate('/mfa'));
    }

    public function supports(Request $request): ?bool
    {
        return $request->request->has(static::PARAMETER_MULTI_FACTOR_FORM);
    }

    public function authenticate(Request $request): Passport
    {
        $token = $this->tokenStorage->getToken();
        $user = $token->getUser();

        $data = $request->request->all(static::PARAMETER_MULTI_FACTOR_FORM);

        return new Passport(
            new UserBadge($token->getUserIdentifier(), function (string $userEmail, ) use ($user) {
                return new Customer(
                    $user->getCustomerTransfer(),
                    $user->getCustomerTransfer()->getEmail(),
                    $user->getCustomerTransfer()->getPassword(),
                    [CustomerPageSecurityPlugin::ROLE_NAME_USER],
                );
            }),
            new CustomCredentials(function() {return true;},$data['otp-token']),
        );
    }

    public function createToken(Passport $passport, string $firewallName): TokenInterface
    {
        return new PostAuthenticationToken(
            $passport->getUser(),
            $firewallName,
            $passport->getUser()->getRoles(),
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse('/');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return null;
    }
}
