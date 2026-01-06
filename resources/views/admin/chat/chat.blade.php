@extends('admin.master')

@section('content')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        /* CSS Bổ sung để xử lý logic ẩn hiện */
        .user-item { cursor: pointer; transition: all 0.2s; }
        .user-item:hover, .user-item.active { background-color: rgba(0,0,0,0.05); }
        
        /* Badge tin nhắn chưa đọc */
        .unread-badge {
            display: none;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
            margin-left: auto;
        }
        .unread-badge.show { display: inline-block; }

        /* Vùng chat scroll */
        .chatbox-height {
            height: 65vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        /* Ẩn input file gốc */
        #imageInput { display: none; }

        /* Preview ảnh */
        #imagePreviewContainer {
            position: absolute;
            bottom: 70px;
            left: 20px;
            z-index: 10;
            background: white;
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        /* Hiệu ứng tin nhắn mới */
        .highlight-new { background-color: rgba(67, 97, 238, 0.1) !important; animation: pulse 1s; }
        @keyframes pulse { 0% { background-color: rgba(67, 97, 238, 0.1); } 100% { background-color: transparent; } }

        /* Ảnh trong tin nhắn */
        .chat-image {
            max-width: 200px;
            border-radius: 8px;
            margin-top: 5px;
            cursor: pointer;
        }
    </style>

    <div class="container-xxl pt-4">
        <div class="row g-1">
            <div class="col-xxl-3 col-lg-4">
                <div class="card h-100">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Chat Hỗ Trợ</h4>
                    </div>

                    <div class="px-3 mb-3">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Tìm kiếm...">
                            <button class="btn btn-sm btn-light"><i class="bx bx-search-alt"></i></button>
                        </div>
                    </div>

                    <div class="user-list px-2" style="height: 65vh; overflow-y: auto;">
                        @foreach ($users as $user)
                            <a href="javascript:void(0);" class="text-body user-item d-block rounded p-2 mb-1" 
                               data-id="{{ $user->id }}">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 position-relative">
                                        <img src="{{ $user->picture ? asset('storage/'.$user->picture) : 'https://img.freepik.com/vector-cao-cap/vector-khuon-mat-nguoi-dan-ong_1072857-7641.jpg' }}" 
                                             class="me-2 rounded-circle" height="40" width="40" style="object-fit: cover" alt="avatar" />
                                        </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="my-0 fs-14">{{ $user->name }}</h5>
                                        <p class="mt-1 mb-0 fs-12 text-muted text-truncate user-last-msg">
                                            Nhấn để xem tin nhắn
                                        </p>
                                    </div>
                                    <div class="d-flex flex-column align-items-end">
                                        <span class="unread-badge" data-unread-for="{{ $user->id }}"></span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-xxl-9 col-lg-8">
                <div class="card position-relative h-100">
                    
                    <div class="card-header d-flex align-items-center">
                        <div class="d-flex align-items-center">
                            <img id="header_chat_img" src="https://img.freepik.com/vector-cao-cap/vector-khuon-mat-nguoi-dan-ong_1072857-7641.jpg" 
                                 class="me-2 rounded-circle" height="40" width="40" style="object-fit: cover" alt="avatar" />
                            <div class="d-flex flex-column">
                                <h5 class="my-0 fs-16 fw-semibold">
                                    <a href="javascript:void(0);" class="text-dark" id="header_chat_name">Chọn người dùng</a>
                                </h5>
                                <p class="mb-0 text-success fw-semibold fst-italic fs-12" id="typingIndicatorHeader" style="display: none;">đang soạn tin...</p>
                            </div>
                        </div>
                    </div>

                    <div class="chat-box position-relative">
                        <ul class="chat-conversation-list p-3 chatbox-height" id="chatMessageContainer">
                            <div class="text-center mt-5 text-muted">
                                <i class='bx bx-message-dots fs-1'></i>
                                <p>Chọn một người dùng để bắt đầu hỗ trợ</p>
                            </div>
                        </ul>

                        <div id="imagePreviewContainer" style="display: none;">
                            <div class="position-relative">
                                <img id="imagePreview" src="" style="max-height: 100px; border-radius: 5px;">
                                <button type="button" id="removePreview" class="btn btn-sm btn-danger position-absolute top-0 end-0 p-0" style="width: 20px; height: 20px;">&times;</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light bg-opacity-50 p-2" id="chatFooter" style="display: none;">
                        <form id="messageForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="receiver_id" name="receiver_id">
                            
                            <div class="row align-items-center">
                                <div class="col d-flex">
                                    <div class="input-group">
                                        <label for="imageInput" class="btn btn-sm btn-light d-flex align-items-center input-group-text" style="cursor: pointer">
                                            <i class="bx bx-paperclip fs-18"></i>
                                        </label>
                                        <input type="file" id="imageInput" accept="image/*">

                                        <input type="text" id="messageInput" class="form-control border-0" placeholder="Nhập tin nhắn..." autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" id="sendMessageButton" class="btn btn-sm btn-primary d-flex align-items-center">
                                        <i class="bx bx-send fs-18"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>

    <script>
        const DEFAULT_AVATAR = 'https://img.freepik.com/vector-cao-cap/vector-khuon-mat-nguoi-dan-ong_1072857-7641.jpg';
        const CURRENT_ADMIN_ID = {{ Auth::id() }};
        let pendingMessageId = 0;

        // LocalStorage keys
        const STORAGE_KEY_ORDER = 'admin_chat_user_order_v2';
        const STORAGE_KEY_UNREAD = 'admin_chat_unread_counts_v2';

        $(document).ready(function() {
            let userOrder = JSON.parse(localStorage.getItem(STORAGE_KEY_ORDER)) || [];
            let unreadCounts = JSON.parse(localStorage.getItem(STORAGE_KEY_UNREAD)) || {};

            // --- 1. CORE FUNCTIONS ---

            function saveOrderAndUnread() {
                localStorage.setItem(STORAGE_KEY_ORDER, JSON.stringify(userOrder));
                localStorage.setItem(STORAGE_KEY_UNREAD, JSON.stringify(unreadCounts));
            }

            function moveUserToTop(userId) {
                userId = String(userId);
                userOrder = userOrder.filter(id => id != userId);
                userOrder.unshift(userId);
                
                const $item = $(`.user-item[data-id="${userId}"]`);
                if ($item.length) {
                    $item.parent().prepend($item); // Di chuyển lên đầu danh sách
                    $item.addClass('highlight-new');
                    setTimeout(() => $item.removeClass('highlight-new'), 1500);
                }
                saveOrderAndUnread();
            }

            function updateUnreadBadge(userId, count) {
                userId = String(userId);
                unreadCounts[userId] = count;
                saveOrderAndUnread();

                const $badge = $(`[data-unread-for="${userId}"]`);
                if (count > 0) {
                    const text = count > 99 ? '99+' : count;
                    $badge.text(text).addClass('show');
                } else {
                    $badge.removeClass('show').text('');
                    delete unreadCounts[userId];
                    saveOrderAndUnread();
                }
            }

            function scrollToBottom() {
                const el = document.getElementById('chatMessageContainer');
                if(el) {
                    setTimeout(() => el.scrollTop = el.scrollHeight, 100);
                }
            }

            // Hàm render tin nhắn theo giao diện mới (<li>)
            function appendMessageWithImage(text, imageUrl, isSender, name, avatar, time) {
                const timeStr = time ? new Date(time).toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'}) : 
                                       new Date().toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'});

                // Xử lý nội dung tin nhắn
                let messageContent = '';
                if(text) messageContent += `<p>${text.replace(/\n/g, '<br>')}</p>`;
                if(imageUrl) {
                    messageContent += `<img src="${imageUrl}" class="chat-image" onclick="window.open(this.src,'_blank')">`;
                }

                // Giao diện mới: Sender dùng class 'odd' và căn phải, Receiver căn trái
                const liClass = isSender ? 'clearfix odd' : 'clearfix';
                const textWrapClass = isSender ? 'd-flex justify-content-end' : 'd-flex';
                // Dropdown menu (nút 3 chấm) - Giữ HTML tĩnh cho đẹp, chức năng thêm sau nếu cần
                const actionsHtml = `
                    <div class="chat-conversation-actions dropdown ${isSender ? 'dropstart' : 'dropend'}">
                        <a href="javascript: void(0);" class="${isSender ? 'pe-1' : 'ps-1'}" data-bs-toggle="dropdown"><i class='bx bx-dots-vertical-rounded fs-18'></i></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Delete</a>
                        </div>
                    </div>
                `;

                let html = `
                    <li class="${liClass}">
                        <div class="chat-conversation-text ms-0" style="width: 100%">
                            <div class="${textWrapClass}">
                                ${isSender ? actionsHtml : ''}
                                <div class="chat-ctext-wrap">
                                    ${messageContent}
                                </div>
                                ${!isSender ? actionsHtml : ''}
                            </div>
                            <p class="text-muted fs-12 mb-0 mt-1 ${isSender ? 'text-end' : ''}">
                                ${timeStr} 
                                ${isSender ? '<i class="bx bx-check-double ms-1 text-primary"></i>' : ''}
                            </p>
                        </div>
                    </li>
                `;

                $('#chatMessageContainer').append(html);
                scrollToBottom();
            }

            // --- 2. EVENTS ---

            // Click chọn user
            $(document).on('click', '.user-item', function() {
                $('.user-item').removeClass('active bg-light');
                $(this).addClass('active bg-light');

                const id = $(this).data('id');
                const name = $(this).find('h5').text();
                const img = $(this).find('img').attr('src');

                // Update Header
                $('#receiver_id').val(id);
                $('#header_chat_name').text(name);
                $('#header_chat_img').attr('src', img);
                $('#chatFooter').show(); // Hiện khung nhập

                // Load Messages
                $('#chatMessageContainer').html('<div class="text-center mt-5"><div class="spinner-border text-primary" role="status"></div></div>');
                
                $.get('{{ route('admin.fetchMessages') }}', { receiver_id: id }, function(res) {
                    $('#chatMessageContainer').empty();
                    if (!res.messages || res.messages.length === 0) {
                        $('#chatMessageContainer').html('<div class="text-center text-muted mt-5"><p>Chưa có tin nhắn nào</p></div>');
                    } else {
                        res.messages.forEach(m => {
                            const isSender = parseInt(m.sender_id) === CURRENT_ADMIN_ID;
                            appendMessageWithImage(
                                m.message || '', 
                                m.image, 
                                isSender, 
                                isSender ? 'Bạn' : name, 
                                isSender ? null : img, 
                                m.created_at
                            );
                        });
                    }
                });

                updateUnreadBadge(id, 0); // Xóa badge unread
                moveUserToTop(id);
            });

            // Gửi tin nhắn
            $('#messageForm').on('submit', function(e) {
                e.preventDefault();
                const message = $("#messageInput").val().trim();
                const receiverId = $('#receiver_id').val();
                const file = document.getElementById('imageInput').files[0];

                if (!message && !file) return;

                // Render tin nhắn giả (Optimistic UI)
                appendMessageWithImage(message, file ? URL.createObjectURL(file) : null, true, 'Bạn', null, new Date());

                // Reset form
                $("#messageInput").val('');
                $('#imageInput').val('');
                $('#imagePreviewContainer').hide();

                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('receiver_id', receiverId);
                if (message) formData.append('message', message);
                if (file) formData.append('image', file);

                // Ajax gửi
                $.ajax({
                    url: '{{ route('admin.sendMessage') }}',
                    type: 'POST',
                    data: formData,
                    processData: false, contentType: false,
                    success: function(res) {
                        if (res.success) moveUserToTop(receiverId);
                        else toastr.error('Lỗi gửi tin');
                    },
                    error: function() { toastr.error('Lỗi kết nối'); }
                });
            });

            // Xử lý ảnh preview
            $('#imageInput').on('change', function() {
                const file = this.files[0];
                if (file) {
                    $('#imagePreview').attr('src', URL.createObjectURL(file));
                    $('#imagePreviewContainer').show();
                }
            });
            $('#removePreview').on('click', function() {
                $('#imageInput').val('');
                $('#imagePreviewContainer').hide();
            });

            // --- 3. PUSHER & REALTIME ---

            const pusher = new Pusher('39863debe06a2e95784f', { cluster: 'us3' }); // Thay key của bạn nếu khác
            const channel = pusher.subscribe('admin-messages.' + CURRENT_ADMIN_ID);

            channel.bind('user-message', function(data) {
                const senderId = String(data.sender_id);
                moveUserToTop(senderId);

                if ($('#receiver_id').val() == senderId) {
                    // Đang chat với người này -> hiện tin nhắn ngay
                    appendMessageWithImage(
                        data.message, 
                        data.image, 
                        false, // isSender = false
                        data.user?.name || 'Khách',
                        data.user?.picture ? '{{ asset('storage') }}/' + data.user.picture : DEFAULT_AVATAR,
                        data.created_at
                    );
                    // Bắn request đánh dấu đã xem (optional)
                } else {
                    // Đang chat người khác -> Tăng badge
                    const current = parseInt(unreadCounts[senderId] || 0);
                    updateUnreadBadge(senderId, current + 1);
                    toastr.info(`Tin nhắn mới từ ${data.user?.name || 'Khách hàng'}`);
                }
            });

            // Typing Indicator logic
            let typingTimer;
            $('#messageInput').on('keyup', function() {
                const rid = $('#receiver_id').val();
                if(!rid) return;
                // Gửi event typing (bạn cần route backend cho việc này nếu muốn)
            });

            channel.bind('user-typing', function(data) {
                if ($('#receiver_id').val() == data.seller_id) {
                     $('#typingIndicatorHeader')[data.is_typing ? 'show' : 'hide']();
                }
            });

            // Khôi phục thứ tự user khi load trang
            function restoreUserOrder() {
                const $list = $('.user-list');
                userOrder.slice().reverse().forEach(userId => { // Reverse để prepend đúng thứ tự
                    const $item = $(`.user-item[data-id="${userId}"]`);
                    if ($item.length) $list.prepend($item);
                });
                
                // Khôi phục badge
                Object.keys(unreadCounts).forEach(uid => {
                    if (unreadCounts[uid] > 0) updateUnreadBadge(uid, unreadCounts[uid]);
                });
            }
            restoreUserOrder();
        });
    </script>
@endsection