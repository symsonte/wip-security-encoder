<?php

namespace Symsonte\Security;

/**
 * @author Yosmany Garcia <yosmanyga@gmail.com>
 */
interface SaltGenerator
{
    /**
     * Generates a salt.
     *
     * @return string
     */
    public function generate();
}
