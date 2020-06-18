<?php
namespace HootSuite;

use HootSuite\TableManager;
use HootSuite\Connection;
use HootSuite\CurlRequest;
use HootSuite\Options\Messages\ScheduleMessage;
use HootSuite\Options\Messages\DeleteMessage;

use HootSuite\Options\SocialProfile\SocialProfiles;
use HootSuite\Options\Media\CreateUrl;
use HootSuite\Options\Media\MediaStatus;

use HootSuite\Utils\TokenGenerator;

class HootsuiteManager
{
    use TokenGenerator;

    protected $_connection;
    protected $_dbmng;
    protected $_hookurls;
    protected $_is_purchased;

    protected $_debugMode;

    private static $_instance;

    public function __construct($token = NULL, $debugMode = false) 
    {
        global $hootsuite_config;
        $this->_is_purchased = $hootsuite_config['hootsuite']['is_purchased'];

        $hook_url = $hootsuite_config['hootsuite']['hootsuite_root'].$hootsuite_config['hootsuite']['hook_file'];
        $this->setHookurls($hook_url);

        $this->_debugMode = $debugMode;

        $tokens = $this->readToken();
        $curlRequest = new CurlRequest();
        $this->_connection = new Connection($tokens['access_token'], $curlRequest, $debugMode);
        // $this->_dbmng = new TableManager();
        if($tokens['refresh_token'] == NULL || $tokens['refresh_token'] === '')
        {
            $this->authenticate();
        }
    }

    public function setIsPurchased($state)
    {
        $this->_is_purchased = $state;
    }

    public function setHookurls($hookurls)
    {
        $this->_hookurls = $hookurls;
    }

    public function postAll()
    {
        $medias = $this->_dbmng->getMedias(['posted_id'=>'']);
        foreach ($medias as $media) {
            postOne($media['id']);
        }        
    }

    public function postOne($draft_id)
    {
        $medias = $this->_dbmng->getMedias(['id'=>$draft_id]);
        $media = [];
        if(sizeof($medias)>0)
            $media = $medias[0];
        else if(!! $media['posted_id'])
            throw new \Exception("your message is already posted:{$draft_id}", 1);
        else
            throw new \Exception("the draft id does not exist:{$draft_id}", 1);

        $fileName = $media['media_path'];
        if(!! file_exists($fileName))
        {
            $sizeBytes = filesize($fileName) + 374;
            $option = new CreateUrl();
            $mimeType = $media['mime_type'];
            $option->setMimeType($mimeType);
            $option->setSizeBytes($sizeBytes);

            $urls_json = json_decode($this->request($option));
            
            $this->debug("<br/>-------------------------STEP 1----------------------------<br/>");
            $this->debug("<br/>Media ID: ".$urls_json->data->id."<br/><br/>");
            $this->debug("<br/>Media ID: ".$urls_json->data->uploadUrl."<br/><br/>");

            $this->_connection->uploadMedia(
                $urls_json->data->uploadUrl, 
                $fileName, 
                $mimeType,
                $sizeBytes 
            );
        }

        $this->debug("-------------------------STEP 2----------------------------<br/>");

        $option = new ScheduleMessage();
        $option->setText($media['title']);
        
        $sheduled_time = new \DateTime($media['scheduled_time']);
        $option->setScheduledSendTime($sheduled_time->format('Y-m-d\TH:i:s\Z'));
        
        $option->setSocialProfileIds([$media['socialid']]);
        $option->setWebhookUrls([$this->_hookurls]);

        //only can use this after purchase
        if(!! $this->_is_purchased)
            $option->setTags(explode(",", $media['tags']));

        if(!! file_exists($fileName)){
            $option->setMedia([[
                "id"=>$urls_json->data->id,
                "videoOptions"=>[
                    "facebook"=>[
                        "title"     =>$media['title'], 
                        "category"  => "ENTERTAINMENT",
                    ]
                ]
            ]]);
        }

        $result = $this->request($option);
        $json = json_decode($result);

        $this->debug("-------------------------STEP 3----------------------------<br/>");

        
        $this->_dbmng->postedMessage($draft_id, $json->data[0]->id);
        $this->_dbmng->setState($json->data[0]->id, "SCHEDULED");
    }

    public function uploadFile($url)
    {
        $sizeBytes = filesize('D:/img.png');
        $this->_connection->uploadMedia(
            $url, 
            'img.png', 
            'image/png',
            $sizeBytes
        );
    }

    public function deletePost($draft_id)
    {
        $draft = $this->_dbmng->getMedias(['id'=>$draft_id]);
        $posted_id = sizeof($draft)>0?$draft[0]['posted_id']:'';
        

        if($posted_id === NULL || strlen($posted_id) <= 0)
            throw new \Exception("Delete processing is failed. Your message is not posted.", 1);

        $option = new DeleteMessage();
        $option->setMessageId($posted_id);
        $this->request($option);

        $this->_dbmng->deleteMedia($draft_id);
        
        return $posted_id;
    }

    public function deleteFromPostID($posted_id)
    {
        $option = new DeleteMessage();
        $option->setMessageId($posted_id);
        $this->request($option);
        return $posted_id;
    }

    public function getSocials()
    {
        $option = new SocialProfiles();
        $result =  $this->request($option);
        return json_decode($result)->data;
    }

    public function getMediaStatus($mediaid)
    {
        $option = new MediaStatus();
        $option->setMediaId($mediaid);
        return $this->request($option);
    }


    public static function instance()
    {
        if(self::$_instance === NULL)
            self::$_instance = new HootsuiteManager();
        return self::$_instance;
    }

    public function request($option)
    {
        try{
           $result = $this->_connection->request($option);
        }
        catch(TokenExpiredException $e){
            $state = $this->refreshToken();
            if($state)
                $this->connection->request($option);
        }

        return $result;
    }

    public function debug($message)
    {
        if(!! $this->_debugMode) echo $message;
    }
}



