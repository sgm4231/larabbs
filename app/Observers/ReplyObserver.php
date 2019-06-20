<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

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
        $reply->topic->updateReplyCount();

        // 通知话题作者有新的评论
        //默认的 User 模型中使用了 trait —— Notifiable，它包含着一个可以用来发通知的方法 notify() ，此方法接收一个通知实例做参数。虽然 notify() 已经很方便，但是我们还需要对其进行定制，我们希望每一次在调用 $user->notify() 时，自动将 users 表里的 notification_count +1 ，这样我们就能跟踪用户未读通知了。
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }
}