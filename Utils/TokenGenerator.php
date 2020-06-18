<?php
namespace HootSuite\Utils;

use HootSuite\Options\Auth\Token;

trait TokenGenerator
{
    protected $_token;
    protected $_refresh_token;
    protected $_token_file = __DIR__."\\token.ini";

    public function authenticate()
    {
        $auth = new Authentication();
        $auth->auth();
    }

    public function generateToken($code, $scope="offline")
    {
        global $hootsuite_config;

        $option = new Token();
        $option->setGrantType("authorization_code");
        $option->setCode($code);
        // $option->setScope($scope);
        
        $redirect_uri = $hootsuite_config['hootsuite']['hootsuite_root'].$hootsuite_config['hootsuite']['redirect_file'];

        $option->setRedirectUri($redirect_uri);

        $auth_code = $hootsuite_config['hootsuite']['client_id'].":".$hootsuite_config['hootsuite']['secret_key'];
        $auth_header = "Authorization:Basic ".base64_encode($auth_code);
        
        $this->debug($auth_header);

        $this->_connection->setHeader(["Content-Type:application/x-www-form-urlencoded", $auth_header]);
        $result = $this->request($option);

        $json = json_decode($result);
        $config['access_token'] = $json->access_token;
        $config['refresh_token'] = $json->refresh_token;
        
        $this->writeToken($config);

        $this->_connection->setToken($json->access_token);

        $this->_connection->setHeader(NULL);

        if($tokens['access_token'] !== $config['access_token'])
            return true;

        return false;    
    }

    public function refreshToken()
    {
        if($this->_refresh_token !== NULL || $this->_refresh_token !== '')
        {
            global $hootsuite_config;
            
            $tokens = $this->readToken();

            $option = new Token();
            $option->setGrantType('refresh_token');
            $option->setRefreshToken($tokens['refresh_token']);


            $redirect_uri = $hootsuite_config['hootsuite']['hootsuite_root'].$hootsuite_config['hootsuite']['redirect_file'];

            $option->setRedirectUri($redirect_uri);
            
    
            $auth_code = $hootsuite_config['hootsuite']['client_id'].":".$hootsuite_config['hootsuite']['secret_key'];
            $auth_header = "Authorization:Basic ".base64_encode($auth_code);
            
            $this->debug($auth_header);

            $this->_connection->setHeader(["Content-Type:application/x-www-form-urlencoded", $auth_header]);

            $result = $this->_connection->request($option);

            $json = json_decode($result);
            $config['access_token'] = $json->access_token;
            $config['refresh_token'] = $json->refresh_token;
            
            $this->writeToken($config);

            $this->_connection->setToken($json->access_token);

            $this->_connection->setHeader(NULL);

            if($tokens['access_token'] !== $config['access_token'])
                return true;

            return false;
        }
    }

    public function readToken()
    {
        $tokens = parse_ini_file(__DIR__."\\token.ini");
        return $tokens;
    }

    public function writeToken($tokens)
    {
        $config = $this->readToken();
        if(isset($tokens['access_token']))
        {
            $config['access_token'] = $tokens['access_token'];
        }
        if(isset($tokens['refresh_token']))
        {
            $config['refresh_token'] = $tokens['refresh_token'];
        }
        write_ini_file($this->_token_file, $config);
    }
}