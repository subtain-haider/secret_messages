<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Services\MessageService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{
    protected $messageService;
    protected $userService;

    /**
     * Constructor to inject the MessageService and UserService.
     *
     * @param MessageService $messageService
     * @param UserService $userService
     */
    public function __construct(MessageService $messageService, UserService $userService)
    {
        $this->messageService = $messageService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of received and sent messages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $userId = auth()->id();
            $receivedMessages = $this->messageService->getReceivedMessages($userId);
            $sentMessages = $this->messageService->getSentMessages($userId);
            $users = $this->userService->getUsersExcept($userId);

            return view('messages.index', compact('receivedMessages', 'sentMessages', 'users'));
        } catch (\Exception $e) {
            Log::error('Error loading messages page', ['error' => $e->getMessage()]);
            Session::flash("error_message", 'Failed to load messages.');
            return back();
        }
    }

    /**
     * Store a newly created message in storage.
     *
     * @param MessageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MessageRequest $request)
    {
        try {
            $this->messageService->createAndEncryptMessage($request->validated(), auth()->id());
            Session::flash("success_message", 'Message sent successfully');
            return redirect()->route('messages.index');
        } catch (\Exception $e) {
            Log::error('Error creating message', ['error' => $e->getMessage()]);
            Session::flash("error_message", 'Unexpected error occured');
            return back();
        }
    }

    /**
     * Display the specified message.
     *
     * @param int $id Message ID
     * @return \Illuminate\View\View
     */
    public function show($id)
    {

        try {
             //$decryptionKey = $request->input('decryption_key', null);  // Default to null if not provided
            $message = $this->messageService->decryptAndShowMessage($id, auth()->id());
            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            Log::error('Error showing message', ['messageId' => $id, 'error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Remove the specified message from storage.
     *
     * @param int $id Message ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $result = $this->messageService->deleteMessage($id, auth()->id());
            return redirect()->route('messages.index')->with('status', $result ? 'Message deleted.' : 'Error deleting message.');
        } catch (\Exception $e) {
            Log::error('Error deleting message', ['messageId' => $id, 'error' => $e->getMessage()]);
            return back()->withErrors('Failed to delete message.');
        }
    }
}
