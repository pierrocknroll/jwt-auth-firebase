<?php

namespace Pierrocknroll\JwtAuthFirebase;

use Firebase\JWT\JWT as FireJWT;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Exceptions\{
    JWTException, TokenInvalidException
};
use Tymon\JWTAuth\Providers\JWT\Provider;

class Firebase extends Provider implements JWT
{
    /**
     * Constructor.
     *
     * @param  string      $secret
     * @param  string      $algo
     * @param  array       $keys
     * @param  string|null $driver
     */
    public function __construct($secret = null, $algo = null, array $keys = [], $driver = null)
    {
        $secret = empty($secret) ? $this->config('secret') : $secret;
        $algo = empty($algo) ? $this->config('algo') : $algo;
        $keys = empty($keys) ? $this->config('keys') : $keys;
        parent::__construct($secret, $algo, $keys);
    }
    
    /**
     * Helper to get the config values.
     *
     * @param  string  $key
     * @param  string  $default
     *
     * @return mixed
     */
    protected function config($key, $default = null)
    {
        return config("jwt.$key", $default);
    }

    /**
     * Create a JSON Web Token.
     *
     * @param array $payload
     *
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     *
     * @return string
     */
    public function encode(array $payload)
    {
        $key = $this->isAsymmetric() ? $this->getPrivateKey() : $this->getSecret();
        try {
            return FireJWT::encode($payload, $key, $this->getAlgo());
        } catch (\Exception $e) {
            throw new JWTException('Could not create token: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Decode a JSON Web Token.
     *
     * @param string $token
     *
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     *
     * @return array
     */
    public function decode($token)
    {
        $key = $this->isAsymmetric() ? $this->getPublicKey() : $this->getSecret();
        try {
            return (array) FireJWT::decode($token, $key, [$this->getAlgo()]);
        } catch (\Exception $e) {
            throw new TokenInvalidException('Could not decode token: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Determine if the algorithm is asymmetric, and thus
     * requires a public/private key combo.
     *
     * @return bool
     */
    protected function isAsymmetric()
    {
        if (isset(FireJWT::$supported_algs[$this->getAlgo()]))
            return in_array('openssl', FireJWT::$supported_algs[$this->getAlgo()]);

        return false;
    }
}
