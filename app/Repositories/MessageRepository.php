<?php
namespace App\Repositories;

use App\Contracts\MessageRepositoryInterface;
use App\Models\Message;

class MessageRepository implements MessageRepositoryInterface
{
    public function getReceivedMessages($userId)
    {
        return Message::where('recipient_id', $userId)->paginate(10);
    }

    public function getSentMessages($userId)
    {
        return Message::where('sender_id', $userId)->paginate(10);
    }

    public function createMessage($data, $userId)
    {
        return Message::create($data + ['sender_id' => $userId]);
    }

    public function getMessageById($id)
    {
        return Message::find($id);
    }

    public function deleteMessage($id, $userId)
    {
        $message = Message::where('id', $id)->where('recipient_id', $userId)->first();
        return $message ? $message->delete() : false;
    }
}
