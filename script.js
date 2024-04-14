// Fonction to load the the messages from server
function loadMessages() {
    // Retrieve the elements of the conversation
    var conversation = document.getElementById("conversation");
    
    // Example : message conversations
    var messages = [
        { sender: "Sender1", content: "Message content 1" },
        { sender: "Sender2", content: "Message content 2" }
    ];

    // Display the messages in the conversation
    messages.forEach(function(message) {
        var messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        messageDiv.innerHTML = "<div class='sender'>" + message.sender + "</div>" +
                                "<div class='content'>" + message.content + "</div>";
        conversation.appendChild(messageDiv);
    });

    // Scroll down to view new messages
    conversation.scrollTop = conversation.scrollHeight;
}

// Load messages on initial page loading
window.onload = loadMessages;

// Send a new message
document.getElementById("messageForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Empêcher le rechargement de la page

    // Retrieve message content
    var messageContent = document.getElementById("messageInput").value;

    // // Example: send the message to the server
    console.log("New message: " + messageContent);

    // Clear the contents of the input box
    document.getElementById("messageInput").value = "";

    // Load messages again to display the new message
    loadMessages();
});
