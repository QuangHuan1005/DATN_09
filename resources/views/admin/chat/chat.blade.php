@extends('admin.master')

@section('content')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

        .admin-chat-wrapper {
            height: 82vh;
            max-height: 900px;
            display: flex;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
            border-radius: 18px;
            overflow: hidden;
            background: white;
            margin: 20px auto;
        }

        .chat-sidebar {
            width: 360px;
            background: #5e6062;
            color: white;
        }

        .sidebar-header {
            padding: 20px;
            background: var(--primary);
            font-size: 1.4rem;
            font-weight: 600;
            text-align: center;
        }

        .user-list {
            max-height: calc(82vh - 80px);
            overflow-y: auto;
        }

        .user-item {
            padding: 14px 20px;
            cursor: pointer;
            transition: all 0.25s;
            border-bottom: 1px solid #3a4149;
            display: flex;
            align-items: center;
        }

        .user-item:hover,
        .user-item.active {
            background: #3a4149;
        }

        .user-item img {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #57606f;
        }

        .user-info {
            margin-left: 14px;
        }

        .user-info .name {
            font-weight: 600;
            font-size: 15px;
        }

        .user-info small {
            opacity: 0.8;
            font-size: 12px;
        }

        .chat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f0f2f5;
        }

        .chat-header-admin {
            padding: 16px 24px;
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
        }

        .chat-header-admin img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
        }

        .chat-header-admin h5 {
            margin: 0 0 0 15px;
            font-size: 1.25rem;
        }

        .chat-body {
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

        .chat-footer-admin {
            padding: 15px 20px;
            background: white;
            border-top: 1px solid #eee;
        }

        .input-group-admin {
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
            background: var(--primary);
            color: white;
            border: none;
        }

        #typingIndicator {
            margin-bottom: 18px;
            animation: fadeIn 0.3s ease;
            margin-left: 20px;
        }

        .typing-animation {
            display: flex;
            gap: 6px;
            align-items: center;
            justify-content: center;
            margin-left: 20px;
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

        .btn-file {
            cursor: pointer;
            color: #555;
            font-size: 18px;
        }

        .btn-file:hover {
            color: #000;
        }

        #imagePreviewContainer {
            margin-top: 10px;
            padding: 0 20px;
            display: none;
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

        #imagePreviewContainer:hover .delete-icon,
        .image-preview-box:hover .delete-icon {
            opacity: 1;
        }

        .chat-image {
            max-width: 250px;
            border-radius: 12px;
            margin-top: 8px;
            display: block;
            cursor: pointer;
        }

        .chat-image:hover {
            opacity: 0.9;
        }

        .emojionearea {
            height: 40px !important;
            border-radius: 5px;
        }
    </style>

    <div class="container-scroller admin">
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper pt-4">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-11">
                            <div class="admin-chat-wrapper">

                                <div class="chat-sidebar">
                                    <div class="sidebar-header">
                                        <i class="fas fa-headset"></i> Hỗ trợ khách hàng
                                    </div>
                                    <div class="user-list">
                                        @foreach ($users as $user)
                                            <div class="user-item d-flex align-items-center" data-id="{{ $user->id }}">
                                                <img src="{{ $user->picture ? asset('storage/' . $user->picture) : 'https://img.freepik.com/vector-cao-cap/vector-khuon-mat-nguoi-dan-ong_1072857-7641.jpg?semt=ais_hybrid&w=740&q=80' }}"
                                                    alt="{{ $user->name }}">
                                                <div class="user-info">
                                                    <div class="name">{{ $user->name }}</div>
                                                    <small>Nhấn để xem tin nhắn</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="chat-main">
                                    <div class="chat-header-admin">
                                        <img id="chat_img"
                                            src="https://img.freepik.com/vector-cao-cap/vector-khuon-mat-nguoi-dan-ong_1072857-7641.jpg?semt=ais_hybrid&w=740&q=80"
                                            alt="User">
                                        <h5 id="chat_name">Chọn một người dùng để chat</h5>
                                    </div>

                                    <div class="chat-body" id="chatMessageContainer">
                                        <div class="text-center text-muted mt-5">
                                            <i class="fas fa-comment-dots fa-3x mb-3"></i>
                                            <p>Chọn một người dùng để bắt đầu hỗ trợ</p>
                                        </div>
                                    </div>

                                    <div id="typingIndicator" style="display:none;">
                                        <div class="chat-message receiver">
                                            <div class="message-avatar">
                                                <img src="" id="typingAvatar" alt="User">
                                            </div>
                                            <div class="typing-animation">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="chat-footer-admin" id="chatFooter" style="display: none;">
                                        <form id="messageForm" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" id="receiver_id" name="receiver_id">
                                            <div class="input-group-admin">
                                                <label for="imageInput" class="btn-file">
                                                    <i class="fas fa-paperclip"></i>
                                                </label>
                                                <input type="file" id="imageInput" accept="image/*"
                                                    style="display: none">
                                                <textarea id="messageInput" placeholder="Nhập tin nhắn..." autocomplete="off" rows="1" style="height: 20px"></textarea>
                                                <button type="submit" id="sendMessageButton">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </form>
                                        <div id="imagePreviewContainer"
                                            style="display:none; margin-top: 10px; padding: 0 20px;">
                                            <div class="image-preview-box">
                                                <img id="imagePreview" src=""
                                                    style="max-width: 120px; border-radius: 6px;">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/emojionearea/dist/emojionearea.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>

    <script>
        const DEFAULT_AVATAR =
            'https://img.freepik.com/vector-cao-cap/vector-khuon-mat-nguoi-dan-ong_1072857-7641.jpg?semt=ais_hybrid&w=740&q=80';
        const CURRENT_ADMIN_ID = {{ Auth::id() }};
        $(document).ready(function() {
            const imageInput = document.getElementById('imageInput');
            const previewBox = document.getElementById('imagePreviewContainer');
            const previewImg = document.getElementById('imagePreview');
            const removeBtn = document.getElementById('removePreview');

            const emojiArea = $("#messageInput").emojioneArea({
                pickerPosition: "top",
                tones: false
            });

            emojiArea[0].emojioneArea.on("keyup", sendTyping);

            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    previewImg.src = URL.createObjectURL(file);
                    previewBox.style.display = "block";
                }
            });

            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                imageInput.value = "";
                previewBox.style.display = "none";
                previewImg.src = "";
            });

            $('#messageForm').on('submit', function(e) {
                e.preventDefault();

                const message = emojiArea[0].emojioneArea.getText().trim();
                const receiverId = $('#receiver_id').val();
                const file = imageInput.files[0];

                if (!message && !file) {
                    toastr.warning('Vui lòng nhập tin nhắn hoặc chọn ảnh');
                    return;
                }

                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('receiver_id', receiverId);
                if (message) formData.append('message', message);
                if (file) formData.append('image', file);

                $.ajax({
                    url: '{{ route('admin.sendMessage') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.success) {
                            emojiArea[0].emojioneArea.setText('');
                            imageInput.value = "";
                            previewBox.style.display = "none";

                            appendMessageWithImage(
                                message,
                                res.data?.image,
                                true,
                                'Bạn',
                                null,
                                res.data?.created_at
                            );
                            scrollToBottom();
                        } else {
                            toastr.error(res.message || 'Gửi thất bại');
                        }
                    },
                    error: function() {
                        toastr.error('Lỗi kết nối');
                    }
                });
            });

            function appendMessageWithImage(text, imageUrl, isSender, displayName, avatar, time = null) {
                const timestamp = time ?
                    new Date(time).toLocaleTimeString('vi-VN', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) :
                    new Date().toLocaleTimeString('vi-VN', {
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

                const avatarHtml = `
                <div class="message-avatar">
                    <img src="${safeAvatar}" alt="${displayName}">
                </div>`;

                const bubbleStyle = isSender ?
                    'background:#4361ee; color:white;' :
                    'background:white;';

                const html = `
                <div class="chat-message ${isSender ? 'sender' : 'receiver'}">
                    ${isSender ? '' : avatarHtml}
                    <div class="message-content" style="${bubbleStyle}">
                        ${content}
                        <div class="timestamp">${timestamp}</div>
                    </div>
                    ${isSender ? avatarHtml : ''}
                </div>`;

                $('#chatMessageContainer').append(html);
                scrollToBottom();
            }

            function loadMessages(userId) {
                $.get('{{ route('admin.fetchMessages') }}', {
                    receiver_id: userId
                }, function(res) {
                    $('#chatMessageContainer').empty();

                    if (!res.messages || res.messages.length === 0) {
                        $('#chatMessageContainer').html(`
                        <div class="text-center text-muted mt-5">
                            <i class="fas fa-comment-dots fa-3x mb-3"></i>
                            <p>Chưa có tin nhắn nào. Hãy bắt đầu cuộc trò chuyện!</p>
                        </div>`);
                        return;
                    }

                    res.messages.forEach(m => {
                        const isSender = parseInt(m.sender_id) === CURRENT_ADMIN_ID;

                        appendMessageWithImage(
                            m.message || '',
                            m.image,
                            isSender,
                            isSender ? 'Bạn' : 'Client',
                            isSender ? null :
                            (m.sender_picture ? '{{ asset('storage') }}/' + m.sender_picture :
                                DEFAULT_AVATAR),
                            m.created_at
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
            const channel = pusher.subscribe('admin-messages.' + CURRENT_ADMIN_ID);

            channel.bind('user-message', function(data) {
                if ($('#receiver_id').val() == data.sender_id) {
                    appendMessageWithImage(
                        data.message,
                        data.image,
                        false,
                        'Client',
                        data.user?.picture ? '{{ asset('storage') }}/' + data.user.picture :
                        DEFAULT_AVATAR,
                        data.created_at
                    );
                }
            });

            $('.user-item').on('click', function() {
                $('.user-item').removeClass('active');
                $(this).addClass('active');

                const id = $(this).data('id');
                const name = $(this).find('.name').text().trim();
                const img = $(this).find('img').attr('src');

                $('#receiver_id').val(id);
                $('#chat_name').text(name);
                $('#chat_img').attr('src', img || DEFAULT_AVATAR);
                $('#typingAvatar').attr('src', img || DEFAULT_AVATAR);
                $('#chatFooter').show();

                loadMessages(id);
            });

            let typingTimer = null;

            function sendTyping() {
                const receiverId = $('#receiver_id').val();
                if (!receiverId) return;

                $.post('/chat/admin-typing', {
                    _token: '{{ csrf_token() }}',
                    receiver_id: receiverId,
                    is_typing: true
                });

                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    $.post('/chat/admin-typing', {
                        _token: '{{ csrf_token() }}',
                        receiver_id: receiverId,
                        is_typing: false
                    });
                }, 1500);
            }

            channel.bind('user-typing', function(data) {
                if ($('#receiver_id').val() == data.seller_id) {
                    $('#typingAvatar').attr('src', $('#chat_img').attr('src'));
                    $('#typingIndicator')[data.is_typing ? 'show' : 'hide']();
                    if (data.is_typing) scrollToBottom();
                }
            });
        });
    </script>
@endsection
