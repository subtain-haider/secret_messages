<?php

namespace App\Contracts;

interface MessageRepositoryInterface
{
    public function getReceivedMessages($userId);
    public function getSentMessages($userId);
    public function createMessage($data, $userId);
    public function getMessageById($id);
    public function deleteMessage($id, $userId);
}
