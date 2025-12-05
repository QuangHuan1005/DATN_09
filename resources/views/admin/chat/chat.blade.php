@extends('admin.master')

@section('content')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <style>
        :root {
            --primary: #4361ee;
            --success: #06d6a0;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray: #95a5a6;
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
            background: #2f3542;
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
            background: url('https://i.imgur.com/6F3qL8q.png') center/cover;
        }

        .message {
            display: flex;
            margin-bottom: 20px;
            max-width: 78%;
            animation: fadeIn 0.35s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.sent {
            margin-left: auto;
            flex-direction: row-reverse;
        }

        .message-bubble {
            background: white;
            padding: 12px 18px;
            border-radius: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .message.sent .message-bubble {
            background: #4361ee;
            color: white;
        }

        .message.received .message-bubble {
            border-bottom-left-radius: 4px;
        }

        .message.sent .message-bubble {
            border-bottom-right-radius: 4px;
        }

        .message img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            margin: 0 10px;
        }

        .message p {
            margin: 0;
            font-size: 15px;
            line-height: 1.5;
        }

        .message .time {
            font-size: 11px;
            opacity: 0.7;
            margin-top: 6px;
            text-align: right;
        }

        .chat-footer-admin {
            padding: 16px 24px;
            background: white;
            border-top: 1px solid #eee;
        }

        .input-group-admin {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #messageInput {
            flex: 1;
            padding: 14px 20px;
            border-radius: 30px;
            border: 1px solid #ddd;
            font-size: 15px;
            transition: all 0.3s;
        }

        #messageInput:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
        }

        #sendMessageButton {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            border: none;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        #sendMessageButton:hover {
            background: #3751cc;
            transform: scale(1.05);
        }

        .no-chat {
            text-align: center;
            color: #777;
            margin-top: 100px;
        }

        .no-chat i {
            font-size: 60px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        #chatFooter {
            transition: all 0.3s ease;
        }
    </style>


    <div class="container-scroller">
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
                                        <div class="no-chat">
                                            <i class="fas fa-comments fa-4x"></i>
                                            <h4>Chào Admin!</h4>
                                            <p>Chọn một người dùng bên trái để bắt đầu hỗ trợ</p>
                                        </div>
                                    </div>

                                    <div class="chat-footer-admin" id="chatFooter" style="display: none;">
                                        <form id="messageForm">
                                            @csrf
                                            <input type="hidden" id="receiver_id" name="receiver_id">
                                            <div class="input-group-admin">
                                                <input type="text" id="messageInput" placeholder="Soạn tin nhắn..."
                                                    autocomplete="off">
                                                <button type="submit" id="sendMessageButton">
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
            $('.user-item').on('click', function() {
                $('.user-item').removeClass('active');
                $(this).addClass('active');

                const name = $(this).find('.name').text();
                const id = $(this).data('id');
                const img = $(this).find('img').attr('src') || DEFAULT_AVATAR;

                $('#receiver_id').val(id);
                $('#chat_name').text(name);
                $('#chat_img').attr('src', img);
                $('#chatFooter').show();

                loadMessages(id);
            });

            $('#messageForm').on('submit', function(e) {
                e.preventDefault();
                const msg = $('#messageInput').val().trim();
                const receiverId = $('#receiver_id').val();
                if (!msg || !receiverId) return;

                $.post('{{ route('admin.sendMessage') }}', {
                    _token: '{{ csrf_token() }}',
                    message: msg,
                    receiver_id: receiverId
                }, function(res) {
                    if (res.success) {
                        $('#messageInput').val('');
                        appendMessage(msg, true, 'You', null, new Date());
                    } else {
                        toastr.error(res.message || 'Gửi thất bại');
                    }
                }).fail(() => toastr.error('Lỗi mạng'));
            });

            function loadMessages(userId) {
                $.get('{{ route('admin.fetchMessages') }}', {
                    receiver_id: userId
                }, function(res) {
                    $('#chatMessageContainer').empty();

                    if (!res.messages || res.messages.length === 0) {
                        $('#chatMessageContainer').html(`
                        <div class="no-chat">
                            <i class="fas fa-comment-medical fa-4x"></i>
                            <p>Chưa có tin nhắn nào. Hãy bắt đầu hỗ trợ khách hàng!</p>
                        </div>
                    `);
                        return;
                    }

                    res.messages.forEach(m => {
                        const isSentByAdmin = m.sender_type === 'admin' || m.sender_id !== userId;
                        const displayName = isSentByAdmin ? 'You' : 'Client';
                        const avatar = isSentByAdmin ? null :
                        DEFAULT_AVATAR; 

                        appendMessage(m.message, isSentByAdmin, displayName, avatar, m.created_at);
                    });

                    scrollToBottom();
                });
            }

            function appendMessage(text, isSent, displayName, avatarUrl, time) {
                const t = time ?
                    new Date(time).toLocaleTimeString('vi-VN', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) :
                    new Date().toLocaleTimeString('vi-VN', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                const avatarHtml = isSent ?
                    '' :
                    `<img src="${avatarUrl || DEFAULT_AVATAR}" alt="${displayName}">`;

                const html = `
                <div class="message ${isSent ? 'sent' : 'received'}">
                    ${avatarHtml}
                    <div class="message-bubble">
                        <p><strong>${displayName}:</strong> ${text}</p>
                        <div class="time">${t}</div>
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

            channel.bind('user-message', function(data) {
                const currentUserId = $('#receiver_id').val();

                if (currentUserId && parseInt(data.user.id) === parseInt(currentUserId)) {
                    appendMessage(
                        data.message,
                        false, 
                        'Client', 
                        DEFAULT_AVATAR, 
                        data.created_at
                    );
                }
            });
        });
    </script>
@endsection