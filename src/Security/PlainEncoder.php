<?php

namespace Symsonte\Security;

/**
 * @author Yosmany Garcia <yosmanyga@gmail.com>
 *
 * @di\service()
 */
class PlainEncoder implements Encoder
{
    /**
     * @var Merger
     */
    private $merger;

    /**
     * @param Merger $merger
     *
     * @di\arguments({
     *     merger: '@symsonte.security.curly_bracket_merger'
     * })
     */
    function __construct(Merger $merger)
    {
        $this->merger = $merger;
    }

    /**
     * {@inheritdoc}
     */
    public function encode($subject, $salt)
    {
        if (empty($salt)) {
            return $subject;
        }

        try {
            return $this->merger->merge($subject, $salt);
        } catch (\DomainException $e) {
            throw new \DomainException($e->getMessage());
        }
    }
}
