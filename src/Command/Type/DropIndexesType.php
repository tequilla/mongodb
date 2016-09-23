<?php

namespace Tequila\MongoDB\Command\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Tequila\MongoDB\Command\CommandTypeInterface;

class DropIndexesType implements CommandTypeInterface
{
    use PrimaryReadPreferenceTrait;

    public static function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(self::getCommandName())
            ->setAllowedTypes(self::getCommandName(), 'string')
            ->setRequired('index')
            ->setAllowedTypes('index', 'string');
    }

    public static function getCommandName()
    {
        return 'dropIndexes';
    }
}