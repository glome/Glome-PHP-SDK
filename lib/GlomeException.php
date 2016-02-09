<?php

namespace Glome\Sdk;

use \Exception;

class GlomeException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
