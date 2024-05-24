<?php
namespace app\task\controller;
use think\Db;


class PrivateLetter
{
    public function del()
    {
        while(true) {
            $result = Db::name('chat_private_letter_history')->where('send_status', 1)->where('create_time', '<', date('Y-m-d'))->limit(100)->select();
            if (!$result) break;
            foreach ($result as $value) {
                $content = $value['content'];
                if (preg_match('/(\/uploads\/.*\/chatMessage\/.*)"/', $content, $match)) {
                    @unlink('./' . $match[1]);
                }
            }
            $ids = array_column($result, 'chat_id');
            Db::name('chat_private_letter_history')->where('chat_id', 'in', $ids)->delete();
        }
       
    }   

}