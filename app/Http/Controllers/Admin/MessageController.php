<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/30
 * Time: 14:57
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Message;
use App\MessageSendRecord;

class MessageController extends Controller
{
    public function index()
    {
        return view('admin.message.list', ['list' => Message::orderBy('created_at', 'desc')->paginate(20)]);
    }

    public function sendRecordList()
    {
        return view('admin.message.send-record-list', ['list' => MessageSendRecord::orderBy('updated_at', 'desc')->paginate(20)]);
    }
}