<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Chat UI</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            margin: 0;
        }
        .sidebar {
            width: 25%;
            background: #2c3e50;
            color: white;
            padding: 20px;
            overflow-y: auto;
        }
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .chat-header {
            background: #34495e;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .chat-messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            background: #ecf0f1;
        }
        .chat-input {
            display: flex;
            padding: 10px;
            background: #bdc3c7;
        }
        .chat-input input {
            flex: 1;
            padding: 10px;
        }
        .chat-input button {
            padding: 10px;
            background: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }
        .user-list div {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
        }
        .user-list div:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .message {
            background: white;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Users</h2>
        <div class="user-list" id="userList"></div>
    </div>
    <div class="chat-container">
        <div class="chat-header" id="chatHeader">Select a user to chat</div>
        <div class="chat-messages" id="chatMessages"></div>
        <div class="chat-input">
            <input type="text" id="messageInput" placeholder="Type a message...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script>
        let selectedUserId = null;
        let selectedUserName = null;

        async function fetchUsers() {
            try {
                const response = await fetch('/api/users'); // Sesuaikan dengan route API Laravel
                const users = await response.json();
                const userList = document.getElementById('userList');
                userList.innerHTML = '';

                users.forEach(user => {
                    const userElement = document.createElement('div');
                    userElement.textContent = user.name;
                    userElement.dataset.userId = user.id;
                    userElement.onclick = () => selectUser(user.id, user.name);
                    userList.appendChild(userElement);
                });
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        }

        function selectUser(userId, userName) {
            selectedUserId = userId;
            selectedUserName = userName;
            document.getElementById("chatHeader").innerText = "Chat with " + userName;
            document.getElementById("chatMessages").innerHTML = "";
        }

        function sendMessage() {
            if (!selectedUserId) {
                alert("Please select a user to chat with.");
                return;
            }
            const messageInput = document.getElementById("messageInput");
            const messageText = messageInput.value.trim();
            if (messageText === "") return;
            const chatMessages = document.getElementById("chatMessages");
            const messageElement = document.createElement("div");
            messageElement.classList.add("message");
            messageElement.innerText = "You: " + messageText;
            chatMessages.appendChild(messageElement);
            messageInput.value = "";
        }

        window.onload = fetchUsers;
    </script>
</body>
</html>
