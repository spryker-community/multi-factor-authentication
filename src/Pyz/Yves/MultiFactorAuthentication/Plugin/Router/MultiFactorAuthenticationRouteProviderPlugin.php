<?php

namespace Pyz\Yves\MultiFactorAuthentication\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class MultiFactorAuthenticationRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    /**
     * @var string
     */
    public const ROUTE_NAME_ENTER_SECOND_FACTOR = 'multiFactorAuthentication/enterSecondFactor';

    /**
     * Specification:
     * - Adds Routes to the RouteCollection.
     *
     * @api
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addEnterSecondFactorRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addEnterSecondFactorRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/enter-second-factor', 'MultiFactorAuthentication', 'EnterSecondFactor', 'indexAction');
        $routeCollection->add(static::ROUTE_NAME_ENTER_SECOND_FACTOR, $route);

        return $routeCollection;
    }
}
