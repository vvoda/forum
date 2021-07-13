<?php

namespace App\Repositories\Topic;

interface TopicRepositoryInterface {
    public function getTopic($topicId);
    public function getTopics($team_id);
    public function createTopic($request);
    public function updateTopic($request);
    public function deleteTopic($request);
    public function deleteFile($topic, $file_id);
}
