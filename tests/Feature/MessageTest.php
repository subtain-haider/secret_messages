<?php
namespace Tests\Feature;

use App\Models\User;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_message_creation_and_encryption()
    {
        $user = User::factory()->create();
        $recipient = User::factory()->create();

        $response = $this->actingAs($user)->post('/messages', [
            'text' => 'Hello, secure world!',
            'recipient_id' => $recipient->id,
            'expires_at' => now()->addDay()
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('messages', [
            'sender_id' => $user->id,
            'recipient_id' => $recipient->id,
        ]);

        $message = Message::first();
        $this->assertNotEquals('Hello, secure world!', $message->text);
    }

    
    public function test_message_expiry()
    {
        $user = User::factory()->create();
        $message = Message::factory()->create([
            'sender_id' => $user->id,
            'expires_at' => Carbon::now()->subMinute()
        ]);

        sleep(1); // Ensure a small delay to let time pass
        Log::debug('Current time:', ['now' => Carbon::now()->toDateTimeString()]);
        Log::debug('Message expires at:', ['expires_at' => $message->expires_at]);
        
        \App\Models\Message::where('expires_at', '<=', Carbon::now())->delete();

        // Check if the message has been soft deleted
        $this->assertSoftDeleted('messages', [
            'id' => $message->id
        ]);
    }
}
