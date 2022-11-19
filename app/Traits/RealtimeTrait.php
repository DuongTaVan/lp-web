<?php

namespace App\Traits;

use Log;
use Image;
use Request;
use LRedis;

trait RealtimeTrait
{
    /**
     * make event
     *
     * @param string $channel
     * @param $data
     */
    public function sendEvent(string $channel, $data)
    {
        try {
            $redis = LRedis::connection();
            $redis->publish($channel, json_encode($data));
        } catch (Exception $exception) {

        }

    }
}
