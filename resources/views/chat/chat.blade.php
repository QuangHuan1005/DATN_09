@extends('master')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
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
            background: #f1f2f6;
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
            background-color: #e5ddd5;
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
    </style>

    <div class="container-scroller">
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
                                            <div class="chat-item d-flex align-items-center" data-id="{{ $admin->id }}">
                                                <img src="{{ $admin->picture ? asset('storage/' . $admin->picture) : 'https://img.freepik.com/vector-cao-cap/vector-khuon-mat-nguoi-dan-ong_1072857-7641.jpg?semt=ais_hybrid&w=740&q=80' }}"
                                                    class="rounded-circle" alt="{{ $admin->name }}">
                                                <div class="profile_info">
                                                    <div class="profile_name">{{ $admin->name }}</div>
                                                    <small class="text-muted">Nhấn để chat</small>
                                                </div>
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

                                    <div class="chat-footer">
                                        <form id="messageForm">
                                            @csrf
                                            <input type="hidden" id="receiver_id" name="receiver_id">
                                            <div class="message-input-group">
                                                <input type="text" id="messageInput" placeholder="Nhập tin nhắn..."
                                                    autocomplete="off">
                                                <button type="submit" id="sendMessageButton" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>

    <script>
        const DEFAULT_AVATAR =
            'https://img.freepik.com/vector-cao-cap/vector-khuon-mat-nguoi-dan-ong_1072857-7641.jpg?semt=ais_hybrid&w=740&q=80';

        $(document).ready(function() {
            $('.chat-item').on('click', function() {
                $('.chat-item').removeClass('active');
                $(this).addClass('active');

                const name = $(this).find('.profile_name').text();
                const id = $(this).data('id');
                const img = $(this).find('img').attr('src');

                $('#receiver_id').val(id);
                $('#chat_name').text(name);
                $('#chat_img').attr('src', img || DEFAULT_AVATAR);

                loadMessages(id);
            });

            $('#messageForm').on('submit', function(e) {
                e.preventDefault();
                const message = $('#messageInput').val().trim();
                const receiverId = $('#receiver_id').val();
                if (!message || !receiverId) return;

                $.post('{{ route('send.Messageofsellertoadmin') }}', {
                    _token: '{{ csrf_token() }}',
                    message: message,
                    receiver_id: receiverId
                }, function(res) {
                    if (res.success) {
                        $('#messageInput').val('');
                        appendMessage(message, true, 'You', res.sender_image || DEFAULT_AVATAR);
                    } else {
                        toastr.error(res.message || 'Gửi thất bại');
                    }
                }).fail(() => toastr.error('Lỗi kết nối'));
            });

            function loadMessages(receiverId) {
                $.get('{{ route('fetch.messagesFromSellerToAdmin') }}', {
                    receiver_id: receiverId
                }, function(res) {
                    $('#chatMessageContainer').empty();

                    if (res.messages.length === 0) {
                        $('#chatMessageContainer').html(`
                        <div class="text-center text-muted mt-5">
                            <i class="fas fa-comment-dots fa-3x mb-3 opacity-50"></i>
                            <p>Chưa có tin nhắn nào. Hãy bắt đầu trò chuyện!</p>
                        </div>
                    `);
                        return;
                    }

                    res.messages.forEach(msg => {
                        const isSender = msg.sender_type === 'seller' || msg.sender_id !==
                            receiverId;
                        const displayName = isSender ? 'You' : 'Admin';
                        const avatar = msg.image || DEFAULT_AVATAR;

                        appendMessage(msg.message, isSender, displayName, avatar, msg.created_at);
                    });

                    scrollToBottom();
                });
            }

            function appendMessage(message, isSender, displayName, image, time = null) {
                const safeImage = image && image.trim() !== '' ? image : DEFAULT_AVATAR;

                const timestamp = time ?
                    new Date(time).toLocaleTimeString('vi-VN', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) :
                    new Date().toLocaleTimeString('vi-VN', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                const html = `
                <div class="chat-message ${isSender ? 'sender' : 'receiver'}">
                    <div class="message-avatar">
                        <img src="${safeImage}" alt="${displayName}" onerror="this.src='${DEFAULT_AVATAR}'">
                    </div>
                    <div class="message-content">
                        <p><strong>${displayName}:</strong> ${message}</p>
                        <div class="timestamp">${timestamp}</div>
                    </div>
                </div>`;

                $('#chatMessageContainer').append(html);
                scrollToBottom();
            }

            function scrollToBottom() {
                const container = $('#chatMessageContainer');
                container.scrollTop(container[0].scrollHeight);
            }

            const pusher = new Pusher('39863debe06a2e95784f', {
                cluster: 'us3'
            });

            const id = {{ Auth::id() }};

            const channel = pusher.subscribe('admin-messages.' + id);

            channel.bind('admin-message', function(data) {
                const currentReceiverId = $('#receiver_id').val();

                if (currentReceiverId &&
                    (data.sender_id == currentReceiverId || data.receiver_id == currentReceiverId)) {

                    const adminImage = (data.admin && data.admin.image) ?
                        data.admin.image :
                        DEFAULT_AVATAR;

                    appendMessage(
                        data.message,
                        false, 
                        'Admin',
                        adminImage,
                        data.created_at
                    );
                }
            });
        });
    </script>
@endsection
