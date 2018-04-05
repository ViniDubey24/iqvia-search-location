<?php
require_once __DIR__ . '/vendor/autoload.php';

use \Firebase\JWT\JWT;

class Session
{

    protected $jwt = null;
    protected $secretKey = 'iqvia';
    protected $algo = 'HS512';

    public function __construct($jwt = null)
    {
        $this->jwt = $jwt;
    }

    public function encodeJWT($data)
    {
        return $this->jwt = JWT::encode($data, $this->secretKey, $this->algo);
    }

    public function getJWT($jwt)
    {
        return $this->jwt;
    }

    public function isValidJWT()
    {
        $returnData = true;
        try {
            $returnData = JWT::decode($this->jwt, $this->secretKey, [$this->algo]);
        } catch (Exception $ex) {
            $returnData = false;
        }
        return $returnData;
    }

    public function getSessionDetails($key = null)
    {
        $sessionDetails = $this->isValidJWT();
        if ($key) {
            $sessionDetails = isset($sessionDetails->$key) ? $sessionDetails->$key : null;
        }
        return $sessionDetails;
    }

}
