<?php
namespace HootSuite\Utils;

/**
 * 
 */
class Authentication
{
    protected $auth_url = "https://platform.hootsuite.com/oauth2/auth";
    protected $params;
    public function __construct()
    {
        global $hootsuite_config;
        var_dump($hootsuite_config);
        $redirect_uri = $hootsuite_config['hootsuite']['hootsuite_root'].$hootsuite_config['hootsuite']['redirect_file'];
        
        $this->params = [
            'response_type' =>  'code',
            'client_id'     =>  $hootsuite_config['hootsuite']['client_id'],
            'scope'         =>  'offline',
            'redirect_uri'  =>  $redirect_uri,
            'state'         =>  ''
        ];
    }

    public function auth()
    {

        $auth_config = http_build_query($this->params);
        $request_url = $this->auth_url.'?'.$auth_config;
        
        echo "<script>
                window.open('{$request_url}','width=710,height=555,left=160,top=170')
            </script>";
    }
}