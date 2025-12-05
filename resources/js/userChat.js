function scrollToBottom() {
    let container = document.getElementById('chatMessageContainer');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
}

var pusher = new Pusher('39863debe06a2e95784f', {
    cluster: 'us3',
    encrypted: true
});

var channel = pusher.subscribe('admin-messages');

channel.bind('admin-message', function(data) {
    console.log('Message received:', data);

    let senderName = data.admin.name;
    let senderImage = data.admin.image;
    let message = data.message;

    let messageTime = new Date(data.created_at).toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit'
    });

    let messageHtml = `
        <div class="chat-message receiver">
            <div class="message-avatar">
                <img src="${senderImage}" class="rounded-circle avatar" alt="${senderName}">
            </div>
            <div class="message-content">
                <p><strong>${senderName}:</strong> ${message}</p>
                <div class="timestamp">${messageTime}</div>
            </div>
        </div>`;

    document.getElementById('chatMessageContainer').insertAdjacentHTML('beforeend', messageHtml);

    scrollToBottom();
});

$(document).ready(function() {

    $('.chat-item').on('click', function() {

        let profileImage = $(this).find('.profile_img').attr('src');
        let profileName = $(this).find('.profile_name').text();
        let receiverId = $(this).find('.id').text();

        $('#receiver_id').val(receiverId);
        $('#chat_img').attr('src', profileImage);
        $('#chat_name').text('Chatting with ' + profileName);

        $.ajax({
            url: fetchMessagesRoute,
            method: 'GET',
            data: { receiver_id: receiverId },
            success: function(response) {
                $('#chatMessageContainer').empty();

                response.messages.forEach(function(message) {

                    let isSender = message.sender_id;
                    let userAvatar = message.image;
                    let userName = message.name;

                    let messageTime = new Date(message.created_at).toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    let messageHtml = `
                        <div class="chat-message ${isSender ? 'sender' : 'receiver'}">
                            <div class="message-avatar">
                                <img src="${userAvatar}" class="rounded-circle avatar">
                            </div>
                            <div class="message-content">
                                <p><strong>${userName}:</strong> ${message.message}</p>
                                <div class="timestamp">${messageTime}</div>
                            </div>
                        </div>`;

                    $('#chatMessageContainer').append(messageHtml);
                });

                scrollToBottom();
            },
            error: function(err) {
                console.error("Fetch error:", err);
            }
        });
    });

    $('#messageForm').on('submit', function(e) {
        e.preventDefault();

        let message = $('#messageInput').val().trim();
        let receiverId = $('#receiver_id').val();

        if (message === "") {
            toastr.error("Message cannot be empty.");
            return;
        }

        $.ajax({
            url: sendMessageRoute,   
            method: "POST",
            data: {
                _token: $('input[name="_token"]').val(),
                message: message,
                receiver_id: receiverId
            },
            beforeSend: function() {
                $('#sendMessageButton').text('Sending...').attr('disabled', true);
            },
            success: function(response) {

                if (response.success) {

                    let userAvatar = response.user.image;
                    let userName = response.user.name;

                    let messageTime = new Date().toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    let messageHtml = `
                        <div class="chat-message sender">
                            <div class="message-avatar">
                                <img src="${userAvatar}" class="rounded-circle avatar">
                            </div>
                            <div class="message-content">
                                <p><strong>${userName}:</strong> ${message}</p>
                                <div class="timestamp">${messageTime}</div>
                            </div>
                        </div>`;

                    $('#chatMessageContainer').append(messageHtml);
                    $('#messageInput').val("");

                    scrollToBottom();
                }

            },
            complete: function() {
                $('#sendMessageButton').text('Send').attr('disabled', false);
            },
            error: function(err) {
                console.error("Send error:", err);
                toastr.error("Failed to send message");
            }
        });
    });
});
