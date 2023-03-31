<?php

namespace Symsonte\Security;

/**
 * @author Yosmany Garcia <yosmanyga@gmail.com>
 *
 * @di\service()
 */
class OrdinarySaltGenerator implements SaltGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }
}
