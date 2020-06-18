<?php
namespace HootSuite\Options\SocialProfile;

use HootSuite\Options\OptionsAbstract;
use HootSuite\Exception\InvalidMimeTypeException;

class SocialProfile extends OptionsAbstract
{
    protected $socialProfileId;
    public function setSocialProfileId($id)
    {
        $this->socialProfileId = $id;
        return $this;
    }

    public function getEndPoint()
    {
        return "/v1/socialProfiles/{$this->socialProfileId}";
    }

    /**
     * @return string
     */
    public function getRequestType(){
        return self::REQUEST_TYPE_GET;
    }
}