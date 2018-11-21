<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 20.11.2018
 */

namespace Umb\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Umb\Services\StringFinderService;

/**
 * Class StringFinderCompilerPass
 * @package Umb\DependencyInjection\Compiler
 */
class StringFinderCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(StringFinderService::class)) {
            return;
        }

        $definition = $container->findDefinition(StringFinderService::class);

        $taggesServices = $container->findTaggedServiceIds('strategy.string_finder_strategies');

        foreach ($taggesServices as $id => $tags) {
            $definition->addMethodCall(
                'addFinderStrategy',
                [new Reference($id)]
            );
        }
    }
}