<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat dengan {{ $lapak->nama_lapak }} - Kantin D-pipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%); }
        #messages-container {
            max-height: 500px;
            overflow-y: auto;
        }
        #messages-container::-webkit-scrollbar {
            width: 6px;
        }
        #messages-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        #messages-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('pembeli.chat.index') }}" class="text-gray-600 hover:text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">{{ $lapak->nama_lapak }}</h1>
                        <p class="text-xs text-gray-500">Chat dengan penjual</p>
                    </div>
                </div>
                <a href="{{ route('pembeli.lapak.select') }}" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition">
                    Kembali
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-6 max-w-4xl">
        @if(session('key') === 'success')
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">
                {{ session('value') }}
            </div>
        @endif

        @if(session('key') === 'error')
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
                {{ session('value') }}
            </div>
        @endif

        <!-- Chat Container -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Messages Area -->
            <div id="messages-container" class="p-6 space-y-4">
                @foreach($messages as $message)
                    <div class="flex {{ $message->sender_type == 'pembeli' ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message->sender_type == 'pembeli' ? 'bg-orange-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                            <p class="text-sm">{{ $message->message }}</p>
                            <p class="text-xs mt-1 opacity-75">{{ $message->created_at->setTimezone('Asia/Jakarta')->format('H:i') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Input Area -->
            <div class="border-t p-4 bg-gray-50">
                <form id="chat-form" action="{{ route('pembeli.chat.store', $lapak->lapak_id) }}" method="POST">
                    @csrf
                    <div class="flex space-x-2">
                        <input 
                            type="text" 
                            name="message" 
                            id="message-input"
                            placeholder="Ketik pesan..." 
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none"
                            required
                            autocomplete="off"
                        >
                        <button 
                            type="submit"
                            class="bg-gradient-to-r from-orange-500 to-pink-500 text-white px-6 py-2 rounded-lg hover:shadow-lg transition font-medium"
                        >
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let lastMessageId = {{ $messages->count() > 0 ? $messages->last()->message_id : 0 }};
        let isPolling = true;

        // Auto scroll to bottom
        function scrollToBottom() {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;
        }

        // Track displayed message IDs to prevent duplicates
        const displayedMessageIds = new Set();
        @foreach($messages as $msg)
            displayedMessageIds.add({{ $msg->message_id }});
        @endforeach

        // Load new messages
        function loadNewMessages() {
            if (!isPolling) return;

            fetch(`{{ route('pembeli.chat.getNewMessages', $lapak->lapak_id) }}?last_message_id=${lastMessageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        const container = document.getElementById('messages-container');
                        // Sort messages by ID to ensure correct order
                        const sortedMessages = data.messages.sort((a, b) => a.id - b.id);
                        
                        sortedMessages.forEach(msg => {
                            // Check if message already displayed
                            if (displayedMessageIds.has(msg.id)) {
                                return; // Skip duplicate
                            }
                            
                            displayedMessageIds.add(msg.id);
                            const messageDiv = document.createElement('div');
                            messageDiv.className = `flex ${msg.is_me ? 'justify-end' : 'justify-start'}`;
                            messageDiv.setAttribute('data-message-id', msg.id);
                            messageDiv.innerHTML = `
                                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${msg.is_me ? 'bg-orange-500 text-white' : 'bg-gray-200 text-gray-800'}">
                                    <p class="text-sm">${msg.message}</p>
                                    <p class="text-xs mt-1 opacity-75">${msg.created_at}</p>
                                </div>
                            `;
                            container.appendChild(messageDiv);
                            lastMessageId = Math.max(lastMessageId, msg.id);
                        });
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error loading messages:', error);
                });
        }

        // Form submit
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const messageInput = document.getElementById('message-input');
            const message = messageInput.value.trim();

            if (!message) return;

            // Clear input immediately
            messageInput.value = '';
            
            // Disable form
            form.querySelector('button').disabled = true;
            messageInput.disabled = true;

            // Store original message for immediate display
            const tempMessage = message;
            const tempTime = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            
            // Add message to DOM IMMEDIATELY (optimistic update)
            const container = document.getElementById('messages-container');
            const tempMessageId = 'temp-' + Date.now();
            const messageDiv = document.createElement('div');
            messageDiv.className = 'flex justify-end';
            messageDiv.setAttribute('data-message-id', tempMessageId);
            messageDiv.innerHTML = `
                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg bg-orange-500 text-white">
                    <p class="text-sm">${tempMessage}</p>
                    <p class="text-xs mt-1 opacity-75">${tempTime}</p>
                </div>
            `;
            container.appendChild(messageDiv);
            scrollToBottom();

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update lastMessageId
                    if (data.message && data.message.message_id) {
                        lastMessageId = Math.max(lastMessageId, data.message.message_id);
                        displayedMessageIds.add(data.message.message_id);
                        
                        // Update the temporary message with real ID and time
                        messageDiv.setAttribute('data-message-id', data.message.message_id);
                        if (data.message.created_at) {
                            const timeElement = messageDiv.querySelector('.text-xs');
                            if (timeElement) {
                                timeElement.textContent = data.message.created_at;
                            }
                        }
                    }
                } else {
                    // Remove message if failed
                    messageDiv.remove();
                    messageInput.value = tempMessage;
                    alert('Gagal mengirim pesan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Remove message if error
                messageDiv.remove();
                messageInput.value = tempMessage;
                alert('Gagal mengirim pesan');
            })
            .finally(() => {
                form.querySelector('button').disabled = false;
                messageInput.disabled = false;
            });
        });

        // Poll for new messages every 2 seconds
        setInterval(loadNewMessages, 2000);

        // Initial scroll
        scrollToBottom();

        // Stop polling when page is hidden
        document.addEventListener('visibilitychange', function() {
            isPolling = !document.hidden;
        });
    </script>
</body>
</html>

