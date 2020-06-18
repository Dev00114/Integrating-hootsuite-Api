<?php
namespace HootSuite\Options\Auth;

use HootSuite\Options\OptionsAbstract;

class Token extends OptionsAbstract
{
    protected $grant_type;
    protected $code;
    protected $redirect_uri;
    protected $member_id;
    protected $organization_id;
    // protected $scope;
    protected $refresh_token;
    protected $client_id;

    public function __construct()
    {
        $this->response_type = 'code';
        // $this->scope = 'offline';
        $this->state = '';
    }

    public function setClientID($client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }

    public function setGrantType($grant_type)
    {
        $this->grant_type = $grant_type;
        return $this;
    }
    
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    
    public function setRedirectUri($redirect_uri)
    {
        $this->redirect_uri = $redirect_uri;
        return $this;
    }
    
    public function setMemberId($member_id)
    {
        $this->member_id = $member_id;
        return $this;
    }
    
    public function setOrganizationId($organization_id)
    {
        $this->organization_id = $organization_id;
        return $this;
    }
    
    // public function setScope($scope)
    // {
    //     $this->scope = $scope;
    //     return $this;
    // }
    
    public function setRefreshToken($refresh_token)
    {
        $this->refresh_token = $refresh_token;
        return $this;
    }
    
    public function getEndPoint()
    {
        return "/oauth2/token";
    }

    /**
     * @return string
     */
    public function getRequestType(){
        return self::REQUEST_TYPE_POST;
    }
}