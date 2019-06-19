<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    //我们要定制此观察器，在 Topic 模型保存时触发的 saving 事件中，
    //对 excerpt 字段进行赋值
    //make_excerpt() 是我们自定义的辅助方法，我们需要在 helpers.php 文件中添加
    public function saving(Topic $topic)
    {
        $topic->excerpt = make_excerpt($topic->body);
    }
}