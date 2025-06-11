<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.AI Assistant'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/atom-one-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css">
    
    <style>
        :root {
            --chatgpt-sidebar: #202123;
            --chatgpt-main-bg: #343541;
            --chatgpt-user-bg: #343541;
            --chatgpt-ai-bg: #444654;
            --chatgpt-text: #ECECF1;
            --chatgpt-input-bg: #40414F;
            --chatgpt-input-border: #565869;
            --chatgpt-button: #10A37F;
            --chatgpt-button-hover: #1A7F64;
        }

        .chat-container {
            display: flex;
            height: calc(100vh - 180px);
            background-color: var(--chatgpt-main-bg);
            color: var(--chatgpt-text);
            font-family: 'Public Sans', sans-serif;
            border-radius: 10px;
            overflow: hidden;
        }

        .chat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            max-width: 100%;
            margin: 0 auto;
            width: 100%;
        }

        #chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 0;
            scroll-behavior: smooth;
        }

        .chat-message {
            display: flex;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .message-container {
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
            line-height: 1.6;
            display: flex;
        }

        .incoming-message {
            background-color: var(--chatgpt-ai-bg);
        }

        .outgoing-message {
            background-color: var(--chatgpt-user-bg);
        }

        .message-icon {
            width: 30px;
            height: 30px;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .user-icon {
            background-color: #5436DA;
            color: white;
        }

        .ai-icon {
            background-color: #10A37F;
            color: white;
        }

        .message-content {
            flex: 1;
            margin-right: 10px;
        }

        .message-content p {
            margin: 0;
            white-space: pre-wrap;
            margin-right: 10px;
        }

        .message-content pre {
            background: #2d2d2d;
            border-radius: 6px;
            padding: 12px;
            overflow-x: auto;
            margin: 10px 0;
        }

        .message-content code {
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }

        .message-content p code {
            background: rgba(255,255,255,0.1);
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 90%;
        }

        .bottom {
            padding: 20px;
            background-color: var(--chatgpt-main-bg);
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .input-container {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
        }

        #message-input {
            width: 100%;
            background-color: var(--chatgpt-input-bg);
            color: var(--chatgpt-text);
            border: 1px solid var(--chatgpt-input-border);
            border-radius: 8px;
            padding: 12px 45px 12px 15px;
            font-size: 16px;
            resize: none;
            height: 52px;
            max-height: 200px;
            outline: none;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: border-color 0.3s;
        }

        #message-input:focus {
            border-color: var(--chatgpt-button);
        }

        .send-button {
            position: absolute;
            right: 10px;
            bottom: 10px;
            background-color: transparent;
            color: var(--chatgpt-text);
            border: none;
            border-radius: 4px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .send-button:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .send-button i {
            font-size: 18px;
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 800px;
            margin: 10px auto 0;
            font-size: 12px;
            color: rgba(255,255,255,0.5);
        }

        #remaining {
            font-weight: 600;
            color: #10A37F;
        }

        .note {
            color: rgba(255,255,255,0.5);
            margin: 0;
            font-style: italic;
        }

        #cursor {
            width: 3px;
            height: 15px;
            background-color: var(--chatgpt-button);
            display: inline-block;
            animation: blink 1s infinite;
        }

        .chat-header {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--chatgpt-text);
            display: flex;
            align-items: center;
        }

        .chat-title i {
            margin-right: 8px;
            color: var(--chatgpt-button);
        }

        .empty-chat {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: rgba(255,255,255,0.6);
            text-align: center;
            padding: 20px;
        }

        .empty-chat i {
            font-size: 48px;
            margin-bottom: 15px;
            color: var(--chatgpt-button);
        }

        .empty-chat h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .empty-chat p {
            max-width: 500px;
            line-height: 1.5;
        }

        @keyframes blink {
            0% { opacity: 0; }
            50% { opacity: 1; }
            100% { opacity: 0; }
        }

        /* Scrollbar styling */
        #chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        #chat-messages::-webkit-scrollbar-track {
            background: var(--chatgpt-main-bg);
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background: var(--chatgpt-input-border);
            border-radius: 3px;
        }

        @media (max-width: 768px) {
            .message-container {
                max-width: 100%;
            }

            .input-container {
                max-width: 100%;
            }

            .chat-container {
                height: calc(100vh - 200px);
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="chat-container">
            <div class="chat-main">
                <div class="chat-header">
                    <div class="chat-title">
                        <i class='bx bx-bot'></i> <?php echo app('translator')->get('l.AI Assistant'); ?>
                    </div>
                </div>

                <div id="chat-messages">
                    <div class="empty-chat" id="empty-state">
                        <i class='bx bx-message-dots'></i>
                        <h3><?php echo app('translator')->get('l.How can I help you today?'); ?></h3>
                        <p><?php echo app('translator')->get('l.Ask me anything or describe what you need help with.'); ?></p>
                    </div>
                </div>

                <div class="bottom">
                    <div class="input-container">
                        <textarea id="message-input" placeholder="<?php echo app('translator')->get('l.Type your message here...'); ?>"></textarea>
                        <button class="send-button" id="send-button">
                            <i class='bx bx-send'></i>
                        </button>
                    </div>
                    <div class="stats-container">
                        <p class="note">* <?php echo app('translator')->get('l.Use English language to reduce token usage'); ?></p>
                        <p><?php echo app('translator')->get('l.Remaining tokens today'); ?>: <span id="remaining"><?php echo e($remaining); ?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        setInterval(function() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?php echo e(route('dashboard.users.ai-getremaining')); ?>', true);
            xhr.onload = function() {
                if (this.status == 200) {
                    var remaining = document.querySelector('#remaining');
                    remaining.innerHTML = this.responseText;
                }
            }
            xhr.send();
        }, 2000);
    </script>

    <script>
        const message_input = document.querySelector("#message-input");
        const message_list = document.querySelector("#chat-messages");
        const send_button = document.querySelector("#send-button");
        const empty_state = document.querySelector("#empty-state");

        const context = [];

        message_input.addEventListener("keyup", function(e) {
            if (e.keyCode == 13 && !e.shiftKey) {
                e.preventDefault();
                if (message_input.value.trim() !== '') {
                    sendMessage();
                }
            }
        });

        send_button.addEventListener("click", function() {
            if (message_input.value.trim() !== '') {
                sendMessage();
            }
        });

        function sendMessage() {
            // Hide empty state on first message
            if (empty_state) {
                empty_state.style.display = 'none';
            }

            add_message("outgoing", message_input.value);
            var element = document.documentElement;
            var bottom = element.scrollHeight - element.clientHeight;
            window.scroll(0, bottom);
            send_message();
        }

        function send_message() {
            const csrfToken = "<?php echo e(csrf_token()); ?>";
            let question = message_input.value;
            let message = add_message("incoming", '<div id="cursor"></div>');
            message_input.value = "";

            fetch("<?php echo e(route('dashboard.users.ai-message')); ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: "message=" + encodeURIComponent(question) + "&context=" + encodeURIComponent(JSON.stringify(
                        context))
                })
                .then(response => response.text())
                .then(data => {
                    const json = JSON.parse(data);
                    if (json.status == "success") {
                        update_message(message, json.message);
                        context.push([question, json.raw_message]);
                    }
                    message_input.focus();
                })
                .catch(error => {
                    update_message(message, '<?php echo app('translator')->get("l.Sorry, there was an error processing your request."); ?>');
                    console.error('Error:', error);
                });
        }

        function add_message(direction, message) {
            const message_item = document.createElement("div");
            message_item.classList.add("chat-message");
            message_item.classList.add(direction + "-message");

            // Create message container with icon
            const messageContainer = document.createElement("div");
            messageContainer.classList.add("message-container");

            // Create icon
            const iconDiv = document.createElement("div");
            iconDiv.classList.add("message-icon");

            if (direction === "outgoing") {
                iconDiv.classList.add("user-icon");
                iconDiv.innerHTML = '<i class="bx bx-user"></i>';
            } else {
                iconDiv.classList.add("ai-icon");
                iconDiv.innerHTML = '<i class="bx bx-bot"></i>';
            }

            // Create content
            const contentDiv = document.createElement("div");
            contentDiv.classList.add("message-content");
            contentDiv.innerHTML = '<p>' + message + '</p>';

            // Assemble the message
            messageContainer.appendChild(iconDiv);
            messageContainer.appendChild(contentDiv);
            message_item.appendChild(messageContainer);

            message_list.appendChild(message_item);
            message_list.scrollTop = message_list.scrollHeight;

            // Apply syntax highlighting to code blocks
            document.querySelectorAll('pre code').forEach((block) => {
                hljs.highlightElement(block);
            });

            return message_item;
        }

        function update_message(message, new_message) {
            const contentDiv = message.querySelector('.message-content');
            contentDiv.innerHTML = '<p>' + new_message + '</p>';

            message_list.scrollTop = message_list.scrollHeight;

            // Apply syntax highlighting to code blocks
            message.querySelectorAll('pre code').forEach((block) => {
                hljs.highlightElement(block);
            });
        }

        // Auto-resize textarea
        message_input.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight < 200) ? (this.scrollHeight) + 'px' : '200px';
        });

        // Focus input on page load
        window.addEventListener('load', function() {
            message_input.focus();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/users/ai/ai.blade.php ENDPATH**/ ?>