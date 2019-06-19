<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

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
        //数据入库前进行过滤(XSS 过滤)
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);

        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}