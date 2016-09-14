<?php

namespace Tequilla\MongoDB\WriteModel;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException as OptionsResolverException;
use Tequilla\MongoDB\Exception\InvalidArgumentException;
use Tequilla\MongoDB\Util\TypeUtils;

trait ValidateUpdateTrait
{
    private static $updateResolver;

    private static function validateUpdate($update)
    {
        if (!is_array($update) && !is_object($update)) {
            throw new InvalidArgumentException(
                sprintf(
                    '$update must be an array or an object, %s given',
                    TypeUtils::getType($update)
                )
            );
        }

        $update = TypeUtils::ensureArrayRecursive($update);

        if (empty($update)) {
            throw new InvalidArgumentException('$update cannot be empty');
        }

        try {
            return self::getUpdateResolver()->resolve($update);
        } catch(OptionsResolverException $e) {
            self::throwException($e);
        } catch(InvalidArgumentException $e) {
            self::throwException($e);
        }

        return null;
    }

    private static function getUpdateResolver()
    {
        if (!self::$updateResolver) {
            $updateResolver = new OptionsResolver();
            $updateResolver->setDefined([
                '$inc',
                '$mul',
                '$rename',
                '$setOnInsert',
                '$set',
                '$unset',
                '$min',
                '$max',
                '$currentDate',
                '$bit',
            ]);

            self::$updateResolver = $updateResolver;
        }

        return self::$updateResolver;
    }

    private static function throwException(\Exception $e)
    {
        throw new InvalidArgumentException(
            sprintf(
                '$update has a wrong format: %s',
                $e->getMessage()
            )
        );
    }
}