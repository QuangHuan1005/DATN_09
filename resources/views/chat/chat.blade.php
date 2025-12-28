@extends('master')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emojionearea/dist/emojionearea.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray: #6c757d;
            --success: #06d6a0;
        }

        .chat-container {
            height: 78vh;
            max-height: 800px;
            display: flex;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            overflow: hidden;
            background: white;
        }

        .chat-list-panel {
            width: 350px;
            border-right: 1px solid #eee;
            background: #f9f9f9;
        }

        .chat-list-header {
            padding: 20px;
            background: var(--primary);
            color: white;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .chat-list {
            max-height: calc(78vh - 80px);
            overflow-y: auto;
        }

        .chat-item {
            padding: 12px 20px;
            cursor: pointer;
            transition: all 0.2s;
            border-bottom: 1px solid #eee;
        }

        .chat-item:hover,
        .chat-item.active {
            background: #e9ecef;
        }

        .chat-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .chat-item .profile_info {
            margin-left: 12px;
        }

        .chat-item .profile_name {
            font-weight: 600;
            color: #2d3436;
            font-size: 15px;
        }

        .chat-main-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f0f2f5;
        }

        .chat-header {
            padding: 18px 25px;
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .chat-header img {
            width: 45px;
            height: 45px;
            border: 3px solid white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .chat-header h4 {
            margin: 0;
            font-size: 1.2rem;
            margin-left: 12px;
        }

        .chat-window {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: url('https://i.imgur.com/6F3qL8q.png') center/cover no-repeat;
            background-color: #f0f2f5;
        }

        .chat-message {
            display: flex;
            margin-bottom: 18px;
            max-width: 80%;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chat-message.sender {
            margin-left: auto;
            flex-direction: row-reverse;
        }

        .chat-message .message-content {
            background: white;
            padding: 12px 16px;
            border-radius: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            margin-left: 10px;
        }

        .chat-message.sender .message-content {
            background: #4361ee;
            color: white;
        }

        .chat-message.receiver .message-content {
            border-bottom-left-radius: 4px;
        }

        .chat-message.sender .message-content {
            border-bottom-right-radius: 4px;
        }

        .chat-message .message-avatar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .chat-message .message-content p {
            margin: 0;
            font-size: 15px;
            line-height: 1.4;
        }

        .chat-message .timestamp {
            font-size: 11px;
            opacity: 0.7;
            margin-top: 5px;
            text-align: right;
        }

        .chat-footer {
            padding: 15px 20px;
            background: white;
            border-top: 1px solid #eee;
        }

        .message-input-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        #messageInput {
            flex: 1;
            border-radius: 30px;
            padding: 12px 20px;
            border: 1px solid #ddd;
            font-size: 15px;
        }

        #messageInput:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        #sendMessageButton {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .default-avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        #typingIndicator {
            margin-bottom: 18px;
            animation: fadeIn 0.3s ease;
        }

        .typing-bubble {
            background: white !important;
            padding: 10px 14px !important;
            border-radius: 18px;
            border-bottom-left-radius: 4px !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: inline-block;
            min-width: 60px;
            max-width: 120px;
            position: relative;
        }

        .typing-animation {
            display: flex;
            gap: 6px;
            align-items: center;
            justify-content: center;
        }

        .typing-animation span {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background-color: #999;
            display: inline-block;
            animation: typingBounce 1.4s infinite ease-in-out;
        }

        .typing-animation span:nth-child(1) {
            animation-delay: -0.32s;
        }

        .typing-animation span:nth-child(2) {
            animation-delay: -0.16s;
        }

        .typing-animation span:nth-child(3) {
            animation-delay: 0s;
        }

        @keyframes typingBounce {

            0%,
            80%,
            100% {
                transform: translateY(0);
                opacity: 0.5;
            }

            40% {
                transform: translateY(-12px);
                opacity: 1;
            }
        }

        #typingIndicator .message-avatar img {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .emojionearea {
            height: 40px !important;
            border-radius: 5px;
        }

        .btn-file {
            cursor: pointer;
            color: #555;
            font-size: 18px;
        }

        .btn-file:hover {
            color: #000;
        }

        #imagePreviewContainer {
            position: relative;
            display: inline-block;
            width: max-content;
        }

        .image-preview-box {
            position: relative;
            display: inline-block;
        }

        .image-preview-box img {
            max-width: 120px;
            border-radius: 6px;
        }

        .delete-icon {
            position: absolute;
            top: 4px;
            right: 4px;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            padding: 6px;
            border-radius: 50%;
            cursor: pointer;
            opacity: 0;
            transition: .3s;
        }

        #imagePreviewContainer:hover .delete-icon {
            opacity: 1;
        }

        .image-preview-box:hover .delete-icon {
            opacity: 1;
        }

        .chat-image {
            max-width: 280px;
            border-radius: 12px;
            margin-top: 8px;
            display: block;
            cursor: pointer;
        }

        .chat-image:hover {
            opacity: 0.9;
        }

        .unread-badge {
            position: absolute;
            top: 10px;
            right: 12px;
            background: #e03131;
            color: white;
            font-size: 11px;
            font-weight: 700;
            min-width: 20px;
            height: 20px;
            text-align: center;
            border-radius: 50%;
            border: 2.5px solid #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            z-index: 10;
            padding: 0 6px;
            box-sizing: border-box;

            display: flex;
            align-items: center;
            justify-content: center;

            line-height: unset;

            display: none;
        }

        .unread-badge.show {
            display: flex !important;
        }

        .unread-badge.big {
            border-radius: 12px;
            min-width: 24px;
            padding: 0 8px;
        }

        .user-list,
        .chat-list {
            transition: all 0.3s ease;
        }

        .user-item,
        .chat-item {
            transition: all 0.3s ease;
            opacity: 1;
        }

        .highlight-new {
            background-color: rgba(67, 97, 238, 0.1) !important;
            animation: pulse 1.5s ease;
        }

        @keyframes pulse {
            0% {
                background-color: rgba(67, 97, 238, 0.1);
            }

            50% {
                background-color: rgba(67, 97, 238, 0.25);
            }

            100% {
                background-color: transparent;
            }
        }
    </style>

    <div class="container-scroller seller">
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper pt-4">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="chat-container">

                                <div class="chat-list-panel">
                                    <div class="chat-list-header">
                                        <h4><i class="fas fa-comments"></i> Tin nhắn với Admin</h4>
                                    </div>
                                    <div class="chat-list">
                                        @foreach ($admins as $admin)
                                            <div class="chat-item d-flex align-items-center position-relative"
                                                data-id="{{ $admin->id }}">
                                                <img src="https://img.freepik.com/vector-cao-cap/vector-khuon-mat-nguoi-dan-ong_1072857-7641.jpg?semt=ais_hybrid&w=740&q=80"
                                                    class="rounded-circle" alt="{{ $admin->name }}">
                                                <div class="profile_info">
                                                    <div class="profile_name">{{ $admin->name }}</div>
                                                    <small class="text-muted">Nhấn để chat</small>
                                                </div>

                                                <span class="unread-badge" data-unread-for="{{ $admin->id }}"></span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="chat-main-panel">
                                    <div class="chat-header">
                                        <div class="d-flex align-items-center">
                                            <img id="chat_img"
                                                src="https://img.freepik.com/vector-cao-cap/vector-khuon-mat-nguoi-dan-ong_1072857-7641.jpg?semt=ais_hybrid&w=740&q=80"
                                                alt="Admin">
                                            <h4 id="chat_name">Chọn một admin để chat</h4>
                                        </div>
                                    </div>

                                    <div class="chat-window" id="chatMessageContainer">
                                        <div class="text-center text-muted mt-5">
                                            <i class="fas fa-comment-dots fa-3x mb-3"></i>
                                            <p>Chọn một admin để bắt đầu trò chuyện</p>
                                        </div>
                                    </div>

                                    <div id="typingIndicator" style="display:none; margin-left:20px;">
                                        <div class="chat-message receiver">
                                            <div class="message-avatar">
                                                <img src="" id="typingAvatar" alt="Admin">
                                            </div>
                                            <div class="typing-animation" style="margin-left: 20px">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="chat-footer" style="display: none">
                                        <form id="messageForm" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" id="receiver_id" name="receiver_id">
                                            <div class="message-input-group">
                                                <label for="imageInput" class="btn-file">
                                                    <i class="fas fa-paperclip"></i>
                                                </label>
                                                <input type="file" id="imageInput" accept="image/*"
                                                    style="display: none">
                                                <textarea id="messageInput" placeholder="Nhập tin nhắn..." autocomplete="off" rows="1" style="height: 20px"></textarea>
                                                <button type="submit" id="sendMessageButton" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </form>
                                        <div id="imagePreviewContainer" class="image-preview-box" style="display:none;">
                                            <img id="imagePreview" src="">
                                            <i id="removePreview" class="fas fa-trash delete-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/emojionearea/dist/emojionearea.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>

    <script>
        const DEFAULT_AVATAR =
            'https://img.freepik.com/vector-cao-cap/vector-khuon-mat-nguoi-dan-ong_1072857-7641.jpg?semt=ais_hybrid&w=740&q=80';
        const CURRENT_USER_ID = {{ Auth::id() }};
        let pendingMessageId = 0;

        $(document).ready(function() {
            const imageInput = document.getElementById('imageInput');
            const previewBox = document.getElementById('imagePreviewContainer');
            const previewImg = document.getElementById('imagePreview');
            const removeBtn = document.getElementById('removePreview');

            const emojioneArea = $("#messageInput").emojioneArea({
                pickerPosition: "top",
                tones: false,
            });

            emojioneArea[0].emojioneArea.on("keyup", function() {
                sendTyping();
            });

            $('.chat-item').on('click', function() {
                $('.chat-item').removeClass('active');
                $(this).addClass('active');

                const name = $(this).find('.profile_name').text().trim();
                const id = $(this).data('id');
                const img = $(this).find('img').attr('src');

                $('#receiver_id').val(id);
                $('#chat_name').text(name);
                $('#chat_img').attr('src', img || DEFAULT_AVATAR);
                $('#typingAvatar').attr('src', img || DEFAULT_AVATAR);

                $('.chat-footer').show();
                loadMessages(id);
                markConversationAsRead(id);
            });

         $('#messageForm').on('submit', function(e) {
    e.preventDefault();

    const message = emojioneArea[0].emojioneArea.getText().trim();
    const receiverId = $('#receiver_id').val();
    const file = imageInput.files[0];

    if (!message && !file) {
        toastr.warning('Vui lòng nhập tin nhắn hoặc chọn ảnh');
        return;
    }

    pendingMessageId++;
    const currentPendingId = 'pending-' + pendingMessageId;

    appendPendingMessage(message, file ? URL.createObjectURL(file) : null, currentPendingId);

    emojioneArea[0].emojioneArea.setText('');
    imageInput.value = "";
    previewBox.style.display = "none";

    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('receiver_id', receiverId);
    if (message) formData.append('message', message);
    if (file) formData.append('image', file);

    $.ajax({
        url: '{{ route('send.Messageofsellertoadmin') }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            if (res.success) {
                replacePendingMessage(
                    currentPendingId,
                    message || '',
                    res.data?.image || null,
                    res.data?.created_at || new Date()
                );
                scrollToBottom();
            } else {
                removePendingMessage(currentPendingId);
                toastr.error(res.message || 'Gửi thất bại');
            }
        },
        error: function() {
            removePendingMessage(currentPendingId);
            toastr.error('Lỗi kết nối, tin nhắn không gửi được');
        }
    });
});

            function appendMessageWithImage(text, imageUrl, isSender, displayName, avatar, time = null) {
                const timestamp = time ? new Date(time).toLocaleTimeString('vi-VN', {
                    hour: '2-digit',
                    minute: '2-digit'
                }) : new Date().toLocaleTimeString('vi-VN', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const safeAvatar = avatar || DEFAULT_AVATAR;

                let content = '';
                if (text) content += `<p>${text.replace(/\n/g, '<br>')}</p>`;
                if (imageUrl) {
                    content +=
                        `<img src="${imageUrl}" class="chat-image" onclick="window.open(this.src, '_blank')">`;
                }

                const messageClass = isSender ? 'sender' : 'receiver';
                const avatarHtml = !isSender ?
                    `<div class="message-avatar"><img src="${safeAvatar}" alt="${displayName}"></div>` : '';

                const html = `
    <div class="chat-message ${messageClass}">
        ${!isSender ? avatarHtml : ''}   <!-- Chỉ hiện avatar nếu là người nhận (Admin) -->
        <div class="message-content">
            ${content}
            <div class="timestamp">${timestamp}</div>
        </div>
        ${isSender ? '' : ''}   <!-- Không hiện avatar bên phải nữa -->
    </div>`;

                $('#chatMessageContainer').append(html);
                scrollToBottom();
            }

            function loadMessages(receiverId) {
                $.get('{{ route('fetch.messagesFromSellerToAdmin') }}', {
                    receiver_id: receiverId
                }, function(res) {
                    $('#chatMessageContainer').empty();

                    if (!res.messages || res.messages.length === 0) {
                        $('#chatMessageContainer').html(`
                        <div class="text-center text-muted mt-5">
                            <i class="fas fa-comment-dots fa-3x mb-3"></i>
                            <p>Chưa có tin nhắn nào. Hãy bắt đầu cuộc trò chuyện!</p>
                        </div>
                    `);
                        return;
                    }

                    res.messages.forEach(msg => {
                        const isSender = parseInt(msg.sender_id) === CURRENT_USER_ID;

                        appendMessageWithImage(
                            msg.message || '',
                            msg.image ? '{{ asset('storage') }}/' + msg.image : null,
                            isSender,
                            isSender ? 'Bạn' : 'Admin',
                            isSender ?
                            (msg.sender_picture ? '{{ asset('storage') }}/' + msg
                                .sender_picture : DEFAULT_AVATAR) :
                            (msg.receiver_picture ? '{{ asset('storage') }}/' + msg
                                .receiver_picture : DEFAULT_AVATAR),
                            msg.created_at
                        );
                    });

                    scrollToBottom();
                });
            }

            function scrollToBottom() {
                const container = $('#chatMessageContainer')[0];
                setTimeout(() => {
                    container.scrollTop = container.scrollHeight;
                }, 100);
            }


            const pusher = new Pusher('39863debe06a2e95784f', {
                cluster: 'us3'
            });
            const channel = pusher.subscribe('admin-messages.' + CURRENT_USER_ID);

            let typingTimer = null;

            function sendTyping() {
                const receiverId = $('#receiver_id').val();
                if (!receiverId) return;

                $.post('/chat/user-typing', {
                    _token: '{{ csrf_token() }}',
                    receiver_id: receiverId,
                    is_typing: true
                });

                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    $.post('/chat/user-typing', {
                        _token: '{{ csrf_token() }}',
                        receiver_id: receiverId,
                        is_typing: false
                    });
                }, 1500);
            }

            channel.bind('admin-typing', function(data) {
                if ($('#receiver_id').val() == data.admin_id) {
                    $('#typingAvatar').attr('src', $('#chat_img').attr('src'));
                    $('#typingIndicator')[data.is_typing ? 'show' : 'hide']();
                    if (data.is_typing) scrollToBottom();
                }
            });

            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    previewImg.src = URL.createObjectURL(file);
                    previewBox.style.display = "flex";
                }
            });

            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                imageInput.value = "";
                previewBox.style.display = "none";
            });

            function updateUnreadBadge(userId, count) {
                const badge = $(`[data-unread-for="${userId}"]`);
                if (count > 0) {
                    badge.text(count > 99 ? '99+' : count).show();
                } else {
                    badge.hide().text('');
                }
            }

            function countUnreadMessages(messages, currentUserId) {
                return messages.filter(m => m.receiver_id == currentUserId && !m.seen).length;
            }

            function markConversationAsRead(receiverId) {
                $.post('{{ route('chat.markAsRead') }}', {
                    _token: '{{ csrf_token() }}',
                    sender_id: receiverId
                }, function(res) {
                    if (res.success) {
                        updateUnreadBadge(receiverId, 0);
                    }
                });
            }

            function loadUnreadCounts() {
                $.get('{{ route('chat.unreadCounts') }}', function(counts) {
                    Object.keys(counts).forEach(userId => {
                        updateUnreadBadge(userId, parseInt(counts[userId]));
                    });
                });
            }

            loadUnreadCounts();

            function moveUserToTop(userId) {
                const item = $(`.user-item[data-id="${userId}"], .chat-item[data-id="${userId}"]`);
                if (item.length === 0) return;

                const list = item.closest('.user-list, .chat-list');

                item.detach().prependTo(list);

                item.addClass('highlight-new');
                setTimeout(() => item.removeClass('highlight-new'), 1500);
            }

            channel.bind('admin-message', function(data) {
                const senderId = data.sender_id;

                moveUserToTop(senderId);
                const currentReceiverId = $('#receiver_id').val();

                if (currentReceiverId && parseInt(data.sender_id) === parseInt(currentReceiverId)) {
                    appendMessageWithImage(
                        data.message,
                        data.image,
                        false,
                        'Admin',
                        data.admin?.picture ? '{{ asset('storage') }}/' + data.admin.picture :
                        DEFAULT_AVATAR,
                        data.created_at
                    );
                    markConversationAsRead(data.sender_id);
                } else {
                    let count = parseInt($(`[data-unread-for="${data.sender_id}"]`).text()) || 0;
                    updateUnreadBadge(data.sender_id, count + 1);
                }
            });

            channel.bind('message-seen', function(data) {
                updateUnreadBadge(data.senderId, 0);
            });

function appendPendingMessage(text, previewImageUrl, pendingId) {
    let content = '';
    if (text) content += `<p>${text.replace(/\n/g, '<br>')}</p>`;
    if (previewImageUrl) {
        content += `<img src="${previewImageUrl}" class="chat-image" onclick="window.open(this.src, '_blank')">`;
    }
    content += `<div class="timestamp" style="font-style:italic; opacity:0.7;">Đang gửi...</div>`;

    const html = `
        <div class="chat-message sender" data-pending-id="${pendingId}">
            <div class="message-content" style="opacity:0.8;">
                ${content}
            </div>
        </div>`;

    $('#chatMessageContainer').append(html);
    scrollToBottom();
}

function replacePendingMessage(pendingId, text, realImageUrl, createdAt) {
    const $pendingMsg = $(`[data-pending-id="${pendingId}"]`);
    if ($pendingMsg.length === 0) return;

    const timestamp = createdAt ? new Date(createdAt).toLocaleTimeString('vi-VN', {
        hour: '2-digit',
        minute: '2-digit'
    }) : new Date().toLocaleTimeString('vi-VN', {
        hour: '2-digit',
        minute: '2-digit'
    });

    let content = '';
    if (text) content += `<p>${text.replace(/\n/g, '<br>')}</p>`;
    if (realImageUrl) {
        content += `<img src="${realImageUrl}" class="chat-image" onclick="window.open(this.src, '_blank')">`;
    }
    content += `<div class="timestamp">${timestamp}</div>`;

    $pendingMsg.find('.message-content')
        .html(content)
        .css('opacity', '1');

    $pendingMsg.removeAttr('data-pending-id');
}

function removePendingMessage(pendingId) {
    $(`[data-pending-id="${pendingId}"]`).fadeOut(300, function() {
        $(this).remove();
    });
}
        });
    </script>
@endsection
