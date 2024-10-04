<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller{
    //
    // -indexListConversation-storeConversation-sendMessage-getMessages

    public function indexListConversation(Request $request){
        $userId = Auth::user()->id;
            // $conversations = Conversation::where('user_one_id', Auth::user()->id)->orWhere('user_two_id', Auth::user()->id)->get();

            // Récupérez les conversations où l'utilisateur est impliqué
            $conversations = Conversation::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['messages' => function ($query) {
                $query->latest()->take(1); // Récupérer le dernier message de chaque conversation
            },'userOne', 'userTwo'])
            ->get();

            // Optionnel : Si tu veux obtenir les autres utilisateurs
            $conversationsWithOtherUser = $conversations->map(function ($conversation) use ($userId) {
                $otherUser = $conversation->getOtherUser($userId);
                return [
                    'conversation' => $conversation,
                    'otherUser' => $otherUser,
                    'lastMessage' => $conversation->messages->isNotEmpty() ? $conversation->messages->first() : null,
                ];
            });

        if ($request->is('admin/*')) {
            
            return view('eventinz_admin.chat.list', compact('conversationsWithOtherUser'));  
        }
        return response()->json($conversationsWithOtherUser);
    }

    public function storeConversation(Request $request){
        // Assurez-vous que les deux utilisateurs sont différents
        if ($request->user_one_id !== $request->user_two_id) {
            $conversation = Conversation::create([
                'user_one_id' => Auth::user()->id,
                'user_two_id' => $request->user_two_id,
            ]);
            
            return response()->json($conversation);
        }

    return response()->json(['error' => 'Les utilisateurs doivent être différents.'], 400);
    }

    public function sendMessage(Request $request){
        // Assurez-vous que la conversation existe
        $conversation = Conversation::find($request->conversation_id);
        
        if (!$conversation) {
            return response()->json(['error' => 'Conversation non trouvée.'], 404);
        }
    
        // Vérifiez que l'utilisateur qui envoie le message fait partie de la conversation
        if (!in_array(auth()->id(), [$conversation->user_one_id, $conversation->user_two_id])) {
            return response()->json(['error' => 'Vous ne pouvez pas envoyer de message dans cette conversation.'], 403);
        }
    
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => auth()->id(),
            'body' => $request->body,
        ]);
    
        return response()->json($message);
    }

    // sendMessageAsAdmin
    public function sendMessageAsAdmin(Request $request){
        // Assurez-vous que la conversation existe
        $conversation = Conversation::find($request->conversation_id);
        
        if (!$conversation) {
            return back()->with('error','Conversation non trouvée.');
        }
    
        // Vérifiez que l'utilisateur qui envoie le message fait partie de la conversation
        if (!in_array(auth()->id(), [$conversation->user_one_id, $conversation->user_two_id])) {
            return back()->with('error','Vous ne pouvez pas envoyer de message dans cette conversation.');
        }
    
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => auth()->id(),
            'body' => $request->body,
        ]);
    
        return back();
    }

    public function getMessages($id){
        $messages = Message::where('conversation_id', $id)->get();
        return response()->json($messages);
    }

    public function getAllConversationAsAdmin($id){
        $messages = Message::where('conversation_id', $id)->get();

        return view('eventinz_admin.chat.list', compact("messages"));        
    }

    public function getMessagesAsAdmin($id){
        $messages = Message::where('conversation_id', $id)->get();
        $conversationUser = Conversation::where('id',$id)->first();

        return view('eventinz_admin.chat.form', compact('messages','conversationUser'));        
    }
}
