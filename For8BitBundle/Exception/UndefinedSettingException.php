<?php

namespace Ilias25\For8BitBundle\Exception;

use RuntimeException;

class UndefinedSettingException extends RuntimeException
{
    /** Message */
    const MESSAGE = 'Param %s not found';

    /**
     * UndefinedSettingException constructor.
     *
     * @param string $paramName
     */
    public function __construct($paramName)
    {
        $message = sprintf(self::MESSAGE, $paramName);

        parent::__construct($message);
    }
}