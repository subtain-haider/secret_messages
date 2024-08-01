<?php

namespace App\Services;

use App\Contracts\MessageRepositoryInterface;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class MessageService
{
    protected $messageRepository;
    protected $encryptionService;

    /**
     * Constructor to inject dependencies.
     *
     * @param MessageRepositoryInterface $messageRepository
     * @param EncryptionService $encryptionService
     */
    public function __construct(MessageRepositoryInterface $messageRepository, EncryptionService $encryptionService)
    {
        $this->messageRepository = $messageRepository;
        $this->encryptionService = $encryptionService;
    }

    /**
     * Retrieve received messages for a user.
     *
     * @param int $userId User ID
     * @return mixed
     */
    public function getReceivedMessages($userId)
    {
        try {
            return $this->messageRepository->getReceivedMessages($userId);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve received messages', ['userId' => $userId, 'error' => $e->getMessage()]);
            throw new RuntimeException('Error retrieving received messages.');
        }
    }

    /**
     * Retrieve sent messages for a user.
     *
     * @param int $userId User ID
     * @return mixed
     */
    public function getSentMessages($userId)
    {
        try {
            return $this->messageRepository->getSentMessages($userId);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve sent messages', ['userId' => $userId, 'error' => $e->getMessage()]);
            throw new RuntimeException('Error retrieving sent messages.');
        }
    }

    /**
     * Create and encrypt a message.
     *
     * @param array $data Message data
     * @param int $userId User ID
     */
    public function createAndEncryptMessage($data, $userId)
    {
        try {
            Log::info('Attempting to create a message', ['user_id' => $userId]);
            $data['text'] = $this->encryptionService->encryptMessage($data['text']);
            $message = $this->messageRepository->createMessage($data, $userId);
            Log::info('Message created', ['message_id' => $message->id]);
        } catch (\Exception $e) {
            Log::error('Failed to create message', ['userId' => $userId, 'data' => $data, 'error' => $e->getMessage()]);
            throw new RuntimeException('Error creating message.');
        }
    }

    /**
     * Decrypt and optionally delete a message after it's read.
     *
     * @param int $id Message ID
     * @param int $userId User ID reading the message
     * @param string|null $decryptionKey Optional decryption key
     * @return mixed
     */
    public function decryptAndShowMessage($id, $userId, $decryptionKey = null)
    {
        try {
            $message = $this->messageRepository->getMessageById($id);

            if (!$message || ($message->recipient_id !== $userId && $message->sender_id !== $userId)) {
                Log::error('Unauthorized access or message not found', ['user_id' => $userId, 'message_id' => $id]);
                throw new RuntimeException('Unauthorized access or message not found.');
            }

            $message->text = $this->encryptionService->decryptMessage($message->text);

            // Alternative decryption method using a passed key (commented out)
            // if ($decryptionKey) {
            //     $message->text = $this->encryptionService->decryptMessageWithKey($message->text, $decryptionKey);
            // }

            if ($userId === $message->recipient_id) {
                Log::info('Message read by recipient', ['user_id' => $userId, 'message_id' => $id]);
                $message->delete();  // Soft delete the message
            }

            return $message;
        } catch (\Exception $e) {
            Log::error('Failed to decrypt/show message', ['messageId' => $id, 'userId' => $userId, 'error' => $e->getMessage()]);
            throw new RuntimeException('Error processing message viewing.');
        }
    }

    /**
     * Delete a message.
     *
     * @param int $id Message ID
     * @param int $userId User ID
     * @return bool
     */
    public function deleteMessage($id, $userId)
    {
        try {
            if ($this->messageRepository->deleteMessage($id, $userId)) {
                Log::info('Message deleted', ['user_id' => $userId, 'message_id' => $id]);
                return true;
            } else {
                throw new RuntimeException('Message could not be deleted.');
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete message', ['userId' => $userId, 'messageId' => $id, 'error' => $e->getMessage()]);
            return false;
        }
    }
}
