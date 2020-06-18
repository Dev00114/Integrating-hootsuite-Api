<?php
namespace HootSuite\Options\Messages;

use HootSuite\Options\OptionsAbstract;

class OutboundMessages extends OptionsAbstract
{
    protected $startTime;
    protected $endTime;
    protected $state;
    protected $socialProfileIds;
    protected $limit;
    protected $cursor;
    protected $includeUnscheduledReviewMsgs;

    public function setTime($start, $end)
    {
        $this->startTime = $start;
        $this->endTime = $end;
        return $this;
    }

    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    public function setSocialProfileIds($ids)
    {
        $this->socialProfileIds = $ids;
        return $this;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }
    public function setCursor($cursor)
    {
        $this->cursor = $cursor;
        return $this;
    }

    public function setIncludeUnscheduledReviewsMsgs($flag)
    {
        $this->includeUnscheduledReviewMsgs = $flag;
    }

    public function getEndPoint()
    {
        return "/v1/messages";
    }

    /**
     * @return string
     */
    public function getRequestType(){
        return self::REQUEST_TYPE_GET;
    }
}