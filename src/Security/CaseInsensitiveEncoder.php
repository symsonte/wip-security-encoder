<?php

namespace Symsonte\Security;

/**
 * @author Yosmany Garcia <yosmanyga@gmail.com>
 *
 * @di\service()
 */
class CaseInsensitiveEncoder implements Encoder
{
    /**
     * @var Encoder
     */
    private $encoder;

    /**
     * @param Encoder $encoder
     *
     * @di\arguments({
     *     encoder: '@symsonte.security.length_safe_encoder'
     * })
     */
    function __construct(Encoder $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * {@inheritdoc}
     */
    public function encode($subject, $salt)
    {
        return $this->encoder->encode(strtolower($subject), strtolower($salt));
    }
}
