<?php

namespace App\Repositories\Topic;

interface TopicRepositoryInterface {
    public function getTopic($topicId);
    public function getTopics($team_id);
    public function createTopic($request);
    public function updateTopic($request);
    public function deleteTopic($request);
    public function createTopicFile($file_id, $topic_id);
    public function deleteTopicFile($file_id, $topic_id);
}
