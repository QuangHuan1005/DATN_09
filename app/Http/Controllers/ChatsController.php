<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\SendAdminMessage;
use App\Events\SendUserMessage;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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


    public function sendMessage(Request $request)
    {
        $request->validate([
            'message'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
            'receiver_id' => 'required|integer|exists:users,id',
        ]);

        if (!$request->message && !$request->hasFile('image')) {
            return response()->json(['success' => false, 'message' => 'Phải có tin nhắn hoặc ảnh']);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        $chat = Chat::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message ?? '',
            'image'       => $imagePath,
        ]);

        broadcast(new SendAdminMessage($chat))->toOthers();

        return response()->json([
            'success' => true,
            'data'    => [
                // DÙNG Storage::url() → luôn trả về URL đúng: /storage/chat_images/...
                'image'      => $imagePath ? Storage::url($imagePath) : null,
                'message'    => $chat->message,
                'created_at' => $chat->created_at->format('Y-m-d H:i:s'),
            ]
        ]);
    }

    public function sendMessageFromUserToAdmin(Request $request)
    {
        $request->validate([
            'message'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
            'receiver_id' => 'required|integer',
        ]);

        if (!$request->message && !$request->hasFile('image')) {
            return response()->json(['success' => false, 'message' => 'Phải có tin nhắn hoặc ảnh']);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        $chat = Chat::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message ?? '',
            'image'       => $imagePath,
        ]);

        event(new SendUserMessage($chat));

        return response()->json([
            'success' => true,
            'data'    => [
                // DÙNG Storage::url() → luôn đúng dù ở route /admin hay /seller
                'image'      => $imagePath ? Storage::url($imagePath) : null,
                'message'    => $chat->message,
                'created_at' => $chat->created_at->format('Y-m-d H:i:s'),
            ]
        ]);
    }

    public function fetchMessages(Request $request)
    {
        $receiverId = $request->input('receiver_id');
        $adminId = Auth::id();

        $messages = Chat::where(function ($query) use ($adminId, $receiverId) {
            $query->where('sender_id', $adminId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($adminId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $adminId);
        })->orderBy('created_at', 'asc')->get();

        // THÊM DÒNG NÀY: chuyển image thành full URL
        $messages->transform(function ($message) {
            if ($message->image) {
                $message->image = Storage::url($message->image); // ← Quan trọng!
            }
            // Nếu bạn có sender_picture, receiver_picture thì cũng xử lý luôn
            if ($message->sender && $message->sender->picture) {
                $message->sender_picture = asset('storage/' . $message->sender->picture);
            }
            if ($message->receiver && $message->receiver->picture) {
                $message->receiver_picture = asset('storage/' . $message->receiver->picture);
            }
            return $message;
        });

        return response()->json([
            'messages' => $messages
        ]);
    }
}
