<?php

namespace App\Http\Controllers;

use App\User;
use EasyWeChat\Foundation\Application;
use Log;

class NotifyController extends Controller
{
    public function wechat(Application $wechat)
    {
        Log::info('request arrived.');
        $wechat->server->setMessageHandler(function ($message) {
            if ($message->MsgType == 'event') {
                switch ($message->Event) {
                    case 'subscribe':
                        if (!$user = User::findByOpenid($message->FromUserName)) {
                            $user = User::registerByOpenid($message->FromUserName);
                        }
                        if ($user->subscribe()) {
                            return '欢迎关注公众号！';
                        } else {
                            return '创建用户失败';
                        }
                        break;
                    case 'unsubscribe':
                        User::findByOpenid($message->FromUserName)->unSubscribe();
                        return null;
                        break;
                    default:
                        return null;
                        break;
                }
            }
        });
        Log::info('return response.');
        return $wechat->server->serve();
    }
}