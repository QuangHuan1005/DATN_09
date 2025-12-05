<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\SendAdminMessage;
use App\Events\SendUserMessage;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function index()
    {
        $admins = User::where('role_id', '1')->get();
        return view('chat.chat', compact('admins'));
    }

    public function fetchMessagesFromUserToAdmin(Request $request)
    {
        $receiverId = $request->input('receiver_id');
        $sellerId = Auth::id();

        $messages = Chat::where(function ($query) use ($sellerId, $receiverId) {
            $query->where('sender_id', $sellerId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($sellerId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $sellerId);
        })->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages]);
    }

    public function sendMessageFromUserToAdmin(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required',
        ]);

        $chat = new Chat();
        $chat->sender_id = Auth::user()->id;
        $chat->receiver_id = $request->input('receiver_id');
        $chat->message = $request->input('message');
        $chat->seen = 0; 
        $chat->save();

        event(new SendUserMessage($chat));

        return response()->json(['success' => true, 'message' => 'Message sent successfully']);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|integer|exists:users,id', 
        ]);

        $LoggedAdminInfo = Auth::user();
        if (!$LoggedAdminInfo) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to send a message',
            ]);
        }

        $message = new Chat();
        $message->sender_id = $LoggedAdminInfo->id;
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $message->save();

        broadcast(new SendAdminMessage($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
        ]);
    }

    public function fetchMessages(Request $request)
    {
        $receiverId = $request->input('receiver_id');

        $adminId = Auth::user()->id;
        $LoggedAdminInfo = Auth::user();

        if (!$LoggedAdminInfo) {
            return response()->json([
                'error' => 'Admin not found. You must be logged in to access messages.'
            ], 404);
        }

        $messages = Chat::where(function ($query) use ($adminId, $receiverId) {
            $query->where('sender_id', $adminId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($adminId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $adminId);
        })->orderBy('created_at', 'asc')->get();

        return response()->json([
            'messages' => $messages
        ]);
    }
}
