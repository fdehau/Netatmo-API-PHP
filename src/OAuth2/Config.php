<?php

namespace Netatmo\Sdk\OAuth2;

use Netatmo\Sdk\Api;

class Config
{
    const OAUTH2_URI = Api::URI . "/oauth2";

    const TOKEN_URI = self::OAUTH2_URI . "/token";

    const AUTHORIZE_URI = self::OAUTH2_URI . "/authorize";

    const REVOKE_URI = self::OAUTH2_URI . "/revoke";

    protected $tokenUri = self::TOKEN_URI;

    protected $authorizeUri = self::AUTHORIZE_URI;

    protected $revokeUri = self::REVOKE_URI;

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var array
     */
    protected $scopes = [];

    /**
     * Create a new OAuth2 configuration
     *
     * @param string $clientId
     * @param string $clientSecret
     *
     * @return Netatmo\OAuth2\Config
     */
    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function getTokenUri()
    {
        return $this->tokenUri;
    }

    public function getAuthorizeUri()
    {
        return $this->authorizeUri;
    }

    public function getRevokeUri()
    {
        return $this->revokeUri;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Set the OAuth2 scopes
     *
     * @param array $scopes
     */
    public function setScopes(array $scopes)
    {
        $this->scopes = $scopes;
    }

    public function setTokenUri($uri)
    {
        $this->tokenUri = $uri;
    }

    public function setAuthorizeUri($uri)
    {
        $this->authorizeUri = $uri;
    }

    public function setRevokeUri($uri)
    {
        $this->revokeUri = $uri;
    }

    public static function fromArray(array $array)
    {
        if (!isset($array['client_id'])) {
            throw new Exceptions\Error("Missing client_id");
        }
        if (!isset($array['client_secret'])) {
            throw new Exceptions\Error("Missing client_secret");
        }
        $config = new self($array['client_id'], $array['client_secret']);
        if (isset($array['scopes'])) {
            $config->setScopes($array['scopes']);
        }
        return $config;
    }

    public function getParams(Grants\Grant $grant)
    {
        $scope = join(" ", $this->getScopes());
        return array_merge(
            [
                "client_id" => $this->getClientId(),
                "client_secret" => $this->getClientSecret(),
                "scope" => $scope,
                "grant_type" => $grant->getType()
            ],
            $grant->getParams()
        );
    }
}
