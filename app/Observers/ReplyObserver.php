<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    /**
     * 回复内容净化处理，防止XSS攻击（使用 HTMLPurifier）
     * @param Reply $reply
     */
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }

    //我们监控 created 事件，当 Elequont 模型数据成功创建时，created 方法将会被调用
    public function created(Reply $reply)
    {
        //上面自增 1 是比较直接的做法，另一个比较严谨的做法是创建成功后计算本话题下评论总数，
        //然后在对其 reply_count 字段进行赋值。这样做的好处多多，一般在做 xxx_count 此类总数缓存字段时，推荐使用此方法：
        //$reply->topic->increment('reply_count', 1);
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();
    }
}