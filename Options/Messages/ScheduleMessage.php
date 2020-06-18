<?php
namespace HootSuite\Options\Messages;

use HootSuite\Options\OptionsAbstract;
use HootSuite\Options\MineType;

class ScheduleMessage extends OptionsAbstract
{

    protected $text;
    protected $socialProfileIds;
    protected $scheduledSendTime;
    protected $webhookUrls;
    protected $tags;
    protected $targeting;
    protected $privacy;
    protected $location;
    protected $emailNotification;
    protected $mediaUrls;
    protected $media;
    protected $extendedInfo;    

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }
    
    public function setSocialProfileIds($socialProfileIds)
    {
        $this->socialProfileIds = $socialProfileIds;
        return $this;
    }


    public function setScheduledSendTime($scheduledSendTime)
    {
        $this->scheduledSendTime = $scheduledSendTime;
        return $this;
    }

    public function setWebhookUrls($webhookUrls)
    {
        $this->webhookUrls = $webhookUrls;
        return $this;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    public function setTargeting($targeting)
    {
        $this->targeting = $targeting;
        return $this;
    }

    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;
        return $this;
    }

    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    public function setEmailNotification($emailNotification)
    {
        $this->emailNotification = $emailNotification;
        return $this;
    }

    public function setMediaUrls($mediaUrls)
    {
        $this->mediaUrls = $mediaUrls;
        return $this;
    }

    public function setMedia($media)
    {
        $this->media = $media;
        return $this;
    }

    public function setExtendedInfo($extendedInfo)
    {
        $this->extendedInfo = $extendedInfo;
        return $this;
    }


    public function getEndPoint()
    {
        return "/v1/messages";
    }


    /**
     * @return string
     */
    public function getRequestType(){
        return self::REQUEST_TYPE_POST;
    }
}