<?php

namespace Pyz\Yves\CustomerPage\Plugin\Router;

use Spryker\Yves\Router\Route\RouteCollection;
use SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin as SprykerCustomerPageRouteProviderPlugin;

class CustomerPageRouteProviderPlugin extends SprykerCustomerPageRouteProviderPlugin
{
    public const ROUTE_NAME_CHANGE_EMAIL_FORM = 'changeEmail/form';

    public const ROUTE_NAME_CHANGE_EMAIL_CONFIRM = 'changeEmail/confirm';

    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = parent::addRoutes($routeCollection);
        $routeCollection = $this->addChangeEmailRoute($routeCollection);
        $routeCollection = $this->addChangeEmailConfirmRoute($routeCollection);

        return $routeCollection;

    }

    private function addChangeEmailRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/change-email-form', 'CustomerPage', 'ChangeEmail', 'changeEmailFormAction');
        $routeCollection->add(static::ROUTE_NAME_CHANGE_EMAIL_FORM, $route);

        return $routeCollection;
    }

    private function addChangeEmailConfirmRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/change-email-confirm', 'CustomerPage', 'ChangeEmail', 'changeEmailConfirmAction');
        $routeCollection->add(static::ROUTE_NAME_CHANGE_EMAIL_CONFIRM, $route);

        return $routeCollection;
    }

}
