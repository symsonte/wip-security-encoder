<?php

namespace Symsonte\Security;

/**
 * @author Yosmany Garcia <yosmanyga@gmail.com>
 *
 * @di\service()
 */
class HashEncoder implements Encoder
{
    /**
     * @var Merger
     */
    private $merger;

    /**
     * @var string
     */
    private $algorithm;

    /**
     * @var int
     */
    private $iterations;

    /**
     * @var bool
     */
    private $useBase64;

    /**
     * @param Merger      $merger
     * @param string|null $algorithm
     * @param int|null    $iterations
     * @param bool|null   $useBase64
     *
     * @di\arguments({
     *     merger: '@symsonte.security.curly_bracket_merger'
     * })
     */
    function __construct(
        Merger $merger,
        $algorithm = 'sha512',
        $iterations = 5000,
        $useBase64 = true
    )
    {
        $this->merger = $merger;
        $this->algorithm = $algorithm;
        $this->iterations = $iterations;
        $this->useBase64 = $useBase64;
    }

    /**
     * {@inheritdoc}
     */
    public function encode($subject, $salt)
    {
        if (!in_array($this->algorithm, hash_algos(), true)) {
            throw new \DomainException(sprintf('The algorithm "%s" is not supported.', $this->algorithm));
        }

        try {
            $salted = $this->merger->merge($subject, $salt);
        } catch (\DomainException $e) {
            throw new \DomainException($e->getMessage());
        }

        $digest = hash($this->algorithm, $salted, true);
        for ($i = 1; $i < $this->iterations; $i++) {
            $digest = hash($this->algorithm, sprintf("%s%s", $digest, $salted), true);
        }

        return $this->useBase64 ? base64_encode($digest) : bin2hex($digest);
    }
}
