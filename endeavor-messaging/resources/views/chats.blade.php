<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}"> 
	<title>Document</title>
	<link rel="stylesheet" href="/css/app.css" type="text/css">

	<style>
		#greeting {
			text-align: center;
		}

		#chat-window {
			height: 400px;
		}
	</style>
</head>
<body>
	<div class="col-lg-4 offset-lg-4">
		<h1 id="greeting">Hello, <span id="username">{{$username}}</span></h1>
		
		<div id="chat-window" class="col-lg-12">
			
		</div>
		<div class="col-lg-12">
			<div id="typingStatus" class="col-lg-12" style="padding: 15px;"></div>
			<input type="text" id="text" class="form-control col-lg-12" autofocus="" onblur="notTyping()">
			<!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
		</div>
	</div>

	<script src="/js/app.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		var username;

		$(document).ready(function() {

			username = $("#username").html();

			pullData();

			$(document).keyup(function(e) {
				if(e.keyCode == 13) {
					sendMessage();
				} else {
					isTyping();
				}
			});
		});

		function pullData() {
			retrieveChatMessages();
			retrieveTypingStatus();
			setTimeout(pullData,3000);
		}

		function retrieveChatMessages() {
			$.post("http://localhost:8000/retrieveChatMessages", {username: username,_token:'{!! csrf_token() !!}'}, function(data) {
				if(data.length > 0) {
					$("#chat-window").append("<br><div>"+data+"</div><br>");
				}
			});
		}

		function retrieveTypingStatus() {
			$.post("http://localhost:8000/retrieveTypingStatus", {username: username,_token:'{!! csrf_token() !!}'}, function(username) {
				if(username.length > 0) {
					$("#typingStatus").html(username+" is typing");
				} else {
					$("#typingStatus").html("");
				}
			});
		}

		function sendMessage() {
			var text = $("#text").val();

			if(text.length > 0) {
				$.post("http://localhost:8000/sendMessage", {text: text, username: username,_token:'{!! csrf_token() !!}'}, function() {
					$("#chat-window").append("<br><div style='text-algin: right;'>"+text+"</div><br>");
					$("#text").val("");
					notTyping();
				});
			}
		}

		function isTyping() {
			$.post("http://localhost:8000/isTyping", {username: username,_token:'{!! csrf_token() !!}'});
		}

		function notTyping() {
			$.post("http://localhost:8000/notTyping", {username: username,_token:'{!! csrf_token() !!}'});
		}
	</script>
</body>
</html>