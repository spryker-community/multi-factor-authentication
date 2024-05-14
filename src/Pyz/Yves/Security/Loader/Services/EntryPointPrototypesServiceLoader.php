<?php

namespace Pyz\Yves\Security\Loader\Services;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Yves\Security\Loader\Services\EntryPointPrototypesServiceLoader as SprykerEntryPointPrototypesServiceLoader;

class EntryPointPrototypesServiceLoader extends SprykerEntryPointPrototypesServiceLoader
{
    public function add(ContainerInterface $container): ContainerInterface
    {
        $container = parent::add($container);
        $container = $this->addEntryPointMultiFactorPrototype($container);
        
        return $container;
    }

    private function addEntryPointMultiFactorPrototype(ContainerInterface $container)
    {
    }

}
