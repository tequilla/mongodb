<?php

namespace Tequila\MongoDB\Options;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tequila\MongoDB\Options\Driver\TypeMapOptions;
use Tequila\MongoDB\Options\Traits\CachedResolverTrait;

class CollectionOptions implements OptionsInterface
{
    use CachedResolverTrait;

    public static function configureOptions(OptionsResolver $resolver)
    {
        DatabaseOptions::configureOptions($resolver);

        $resolver
            ->setDefined('typeMap')
            ->setAllowedTypes('typeMap', 'array')
            ->setDefault('typeMap', TypeMapOptions::getDefaultTypeMap())
            ->setNormalizer('typeMap', function(Options $options, array $typeMap) {
                return TypeMapOptions::resolve($typeMap);
            });
    }
}