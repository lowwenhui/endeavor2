<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Chat;
use App\ChatMessage;

class ChatController extends Controller
{
	public function sendMessage() {
		$username = Input::get('username');
		$text = Input::get('text');

		$chatMessage = new ChatMessage();
		$chatMessage->sender_username = $username;
		$chatMessage->messages = $text;
		$chatMessage->save();
	}

	public function isTyping() {
		$username = Input::get('username');

		$chat = Chat::find(1);
		if($chat->user1 == $username) {
			$chat->user1_is_typing = true;
		} else {
			$chat->user2_is_typing = true;	
		}
		$chat->save();
	}

	public function notTyping() {
		$username = Input::get('username');

		$chat = Chat::find(1);
		if($chat->user1 == $username) {
			$chat->user1_is_typing = false;
		} else {
			$chat->user2_is_typing = false;	
		}
		$chat->save();		
	}

	public function retrieveChatMessages() {
		$username = Input::get('username');
		
		$message = ChatMessage::where('sender_username','!=',$username)->where('read','=',0)->first();
		if(count($message) > 0) {
			$message->read = true;
			$message->save();
			echo $message->messages;
		}
	}

	public function retrieveTypingStatus() {
		$username = Input::get('username');

		$chat = Chat::find(1);
		if($chat->user1 == $username) {
			if($chat->user2_is_typing) {
				return $chat->user2;
			}
		} else {
			if($chat->user1_is_typing) {
				return $chat->user1;
			}
		}		
	}
}
