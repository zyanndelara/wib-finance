<!-- ===== FLOATING WIDGETS (Chat + Calendar) ===== -->
<style>
    /* --- Floating Bar Container --- */
    #floatWidgetsBar {
        position: fixed;
        bottom: 24px;
        right: 24px;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
        z-index: 1200;
    }

    /* --- Shared widget wrapper --- */
    .float-widget-wrap {
        position: relative;
        display: flex;
        flex-direction: row;
        align-items: flex-end;
    }

    /* --- Shared button style --- */
    .float-fab {
        width: 52px;
        height: 52px;
        background: linear-gradient(145deg, #5a8032, #436026);
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 1.3rem;
        cursor: pointer;
        box-shadow: 0 4px 18px rgba(67,96,38,0.45), 0 1px 4px rgba(0,0,0,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
        flex-shrink: 0;
    }
    .float-fab:hover {
        background: linear-gradient(145deg, #4e7029, #31471b);
        transform: scale(1.10);
        box-shadow: 0 6px 24px rgba(67,96,38,0.55), 0 2px 6px rgba(0,0,0,0.14);
    }

    /* --- Shared panel base --- */
    .float-panel {
        position: absolute;
        bottom: 0;
        right: 64px;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 12px 40px rgba(67,96,38,0.22), 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid rgba(67,96,38,0.10);
        display: none;
        overflow: hidden;
        animation: fadeSlideLeft 0.22s ease;
    }
    .float-panel.open { display: block; }

    @keyframes fadeSlideLeft {
        from { opacity: 0; transform: translateX(18px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    /* ---- CALENDAR ---- */
    #floatCalendarPanel {
        width: 300px;
    }
    .cal-header {
        background: linear-gradient(135deg, #5a8032 0%, #3a5220 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        font-weight: 700;
        font-size: 1rem;
    }
    .cal-header button {
        background: none;
        border: none;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        padding: 4px 10px;
        border-radius: 6px;
        transition: background 0.15s;
    }
    .cal-header button:hover { background: rgba(255,255,255,0.18); }

    .cal-days-header {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        background: #eef5e6;
        text-align: center;
        font-size: 0.74rem;
        font-weight: 700;
        color: #436026;
        padding: 8px 0;
        border-bottom: 1px solid #ddecc8;
    }
    .cal-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        padding: 8px 10px 14px;
        gap: 3px;
        background: #fff;
    }
    .cal-grid .cal-day {
        text-align: center;
        padding: 7px 2px;
        font-size: 0.84rem;
        border-radius: 8px;
        cursor: default;
        color: #2d2d2d;
        transition: background 0.12s;
    }
    .cal-grid .cal-day:not(.other-month):not(.today):hover {
        background: #eef5e6;
    }
    .cal-grid .cal-day.today {
        background: linear-gradient(135deg, #5a8032, #3a5220);
        color: white;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(67,96,38,0.30);
    }
    .cal-grid .cal-day.other-month { color: #d0d0d0; }
    .cal-grid .cal-day.sunday { color: #e53935; }
    .cal-grid .cal-day.today { color: white; }

    /* ---- CHAT ---- */
    #floatChatPanel {
        width: 320px;
        display: none;
        flex-direction: column;
    }
    #floatChatPanel.open { display: flex; animation: fadeSlideLeft 0.22s ease; }

    .chat-header {
        background: linear-gradient(135deg, #5a8032 0%, #3a5220 100%);
        color: white;
        padding: 13px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 700;
        font-size: 1rem;
    }
    .chat-header .chat-title-row { display: flex; align-items: center; gap: 8px; }
    .chat-header .chat-avatar {
        width: 32px; height: 32px;
        background: rgba(255,255,255,0.22);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
    }
    .chat-header .chat-close {
        background: none; border: none; color: white;
        font-size: 1.1rem; cursor: pointer;
        padding: 2px 7px; border-radius: 6px;
        transition: background 0.15s;
    }
    .chat-header .chat-close:hover { background: rgba(255,255,255,0.18); }

    .chat-messages {
        height: 240px;
        overflow-y: auto;
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        background: linear-gradient(180deg, #f4f8ee 0%, #f9fbf6 100%);
    }
    .chat-messages::-webkit-scrollbar { width: 4px; }
    .chat-messages::-webkit-scrollbar-thumb { background: #c5d9b0; border-radius: 4px; }

    .chat-msg {
        max-width: 78%; padding: 8px 12px;
        border-radius: 14px; font-size: 0.88rem;
        line-height: 1.4; word-break: break-word;
    }
    .chat-msg.sent {
        background: linear-gradient(135deg, #5a8032, #3a5220);
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
        box-shadow: 0 2px 8px rgba(67,96,38,0.22);
    }
    .chat-msg.received {
        background: #ffffff;
        color: #222;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
        border: 1px solid #ddecc8;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }
    .chat-msg .chat-time { font-size: 0.71rem; opacity: 0.62; margin-top: 3px; text-align: right; }

    .chat-input-row {
        display: flex;
        padding: 10px 12px;
        gap: 8px;
        border-top: 1px solid #e8f0df;
        background: #fff;
    }
    .chat-input-row input {
        flex: 1;
        padding: 9px 12px;
        border: 1px solid #cde3b0;
        border-radius: 20px;
        font-size: 0.88rem;
        outline: none;
        color: #333;
        transition: border 0.15s;
    }
    .chat-input-row input:focus { border-color: #436026; }
    .chat-input-row button {
        background: linear-gradient(145deg, #5a8032, #436026);
        color: white; border: none;
        border-radius: 50%; width: 36px; height: 36px;
        font-size: 1rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.15s, transform 0.15s; flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(67,96,38,0.28);
    }
    .chat-input-row button:hover { background: linear-gradient(145deg, #4e7029, #31471b); transform: scale(1.08); }
    .chat-input-row .chat-attach-btn {
        background: #f0f7e6; color: #5a8032;
        border: 1px solid #cde3b0;
        box-shadow: none;
    }
    .chat-input-row .chat-attach-btn:hover { background: #e0f0cc; transform: scale(1.08); }

    /* --- reply button on hover --- */
    .chat-msg-wrap {
        display: flex;
        align-items: flex-end;
        gap: 4px;
    }
    .chat-msg-wrap.sent    { flex-direction: row-reverse; }
    .chat-msg-wrap.received { flex-direction: row; }
    .chat-reply-btn {
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.15s;
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 3px 5px;
        font-size: 0.8rem;
        border-radius: 50%;
        flex-shrink: 0;
        line-height: 1;
        margin-bottom: 20px;
    }
    .chat-msg-wrap:hover .chat-reply-btn {
        opacity: 1;
        pointer-events: auto;
    }
    .chat-reply-btn:hover { color: #5a8032; background: #f0f7e6; }

    /* --- reply preview strip above input --- */
    #chatReplyPreview {
        display: none;
        align-items: stretch;
        padding: 6px 12px 0;
        background: #fff;
        gap: 6px;
    }
    .reply-preview-inner {
        flex: 1;
        border-left: 3px solid #5a8032;
        padding: 3px 8px;
        background: #f0f7e6;
        border-radius: 0 6px 6px 0;
        font-size: 0.78rem;
        overflow: hidden;
    }
    .reply-preview-inner .rp-sender {
        font-weight: 700;
        color: #5a8032;
        font-size: 0.74rem;
        margin-bottom: 1px;
    }
    .reply-preview-inner .rp-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #555;
    }
    .reply-cancel-btn {
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        font-size: 1rem;
        padding: 0 4px;
        align-self: center;
        line-height: 1;
    }
    .reply-cancel-btn:hover { color: #e53935; }

    /* --- quote block inside bubble --- */
    .chat-quote-block {
        border-left: 3px solid rgba(255,255,255,0.55);
        background: rgba(0,0,0,0.1);
        border-radius: 0 5px 5px 0;
        padding: 3px 7px;
        margin-bottom: 5px;
        font-size: 0.77rem;
    }
    .chat-msg.received .chat-quote-block {
        border-left-color: #5a8032;
        background: #e8f5d8;
    }
    .chat-quote-block .qb-sender {
        font-weight: 700;
        font-size: 0.73rem;
        margin-bottom: 2px;
    }
    .chat-msg.sent     .chat-quote-block .qb-sender { color: rgba(255,255,255,0.9); }
    .chat-msg.received .chat-quote-block .qb-sender { color: #436026; }
    .chat-quote-block .qb-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        opacity: 0.75;
    }

    #chatFilePreview {
        display: none;
        align-items: center;
        gap: 8px;
        padding: 7px 12px 0;
        background: #fff;
        font-size: 0.82rem;
        color: #333;
    }
    #chatFilePreview img {
        max-height: 54px;
        max-width: 72px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #cde3b0;
    }
    #chatFilePreview .preview-name {
        flex: 1; overflow: hidden;
        white-space: nowrap; text-overflow: ellipsis;
    }
    #chatFilePreview .preview-remove {
        background: none; border: none; color: #e53935;
        cursor: pointer; font-size: 1rem; padding: 0 4px;
        line-height: 1;
    }
    .chat-attachment-img {
        display: block;
        max-width: 180px;
        max-height: 140px;
        border-radius: 8px;
        margin-top: 5px;
        cursor: pointer;
        border: 1px solid rgba(0,0,0,0.1);
    }
    .chat-attachment-file {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 5px;
        padding: 5px 10px;
        background: rgba(0,0,0,0.07);
        border-radius: 8px;
        font-size: 0.8rem;
        text-decoration: none;
        color: inherit;
    }
    .chat-attachment-file:hover { text-decoration: underline; }

    #chatUnreadBadge {
        position: absolute;
        top: -4px; right: -4px;
        background: #e53935; color: white;
        border-radius: 50%; width: 18px; height: 18px;
        font-size: 0.7rem; font-weight: 700;
        display: none; align-items: center; justify-content: center;
    }
</style>

<!-- Floating Widgets Bar -->
<div id="floatWidgetsBar">

    <!-- Calendar Widget -->
    <div class="float-widget-wrap">
        <div id="floatCalendarPanel" class="float-panel">
            <div class="cal-header">
                <button onclick="calChangeMonth(-1)"><i class="fa fa-chevron-left"></i></button>
                <span id="calMonthLabel"></span>
                <button onclick="calChangeMonth(1)"><i class="fa fa-chevron-right"></i></button>
            </div>
            <div class="cal-days-header">
                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div>
                <div>Thu</div><div>Fri</div><div>Sat</div>
            </div>
            <div class="cal-grid" id="calGrid"></div>
        </div>
        <button id="floatCalendarBtn" class="float-fab" title="Calendar" onclick="toggleCalendar()">
            <i class="fa fa-calendar-alt"></i>
        </button>
    </div>

    <!-- Chat Widget -->
    <div class="float-widget-wrap">
        <div id="floatChatPanel" class="float-panel">
            <div class="chat-header">
                <div style="display:flex;align-items:center;gap:6px;">
                    @if(auth()->user()->role === 'admin')
                    <button id="chatBackBtn" class="chat-close" onclick="chatGoBack()" style="display:none;" title="Back to conversations"><i class="fa fa-arrow-left"></i></button>
                    @endif
                    <div class="chat-title-row">
                        <div class="chat-avatar"><i class="fa fa-headset"></i></div>
                        <div>
                            <div style="font-size:0.95rem;">Finance Director</div>
                            <div style="font-size:0.72rem;font-weight:400;opacity:0.8;" id="chatOnlineStatus">Online</div>
                        </div>
                    </div>
                </div>
                <button class="chat-close" onclick="toggleChat()"><i class="fa fa-times"></i></button>
            </div>

            @if(auth()->user()->role === 'admin')
            <!-- Admin: conversation list -->
            <div id="chatConversationList" style="max-height:340px;overflow-y:auto;">
                <div style="padding:8px 14px 6px;font-size:0.75rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#436026;border-bottom:1px solid #eef5e6;background:#f9fbf6;">Conversations</div>
                <div style="padding:16px;color:#999;font-size:0.82rem;text-align:center;">Loading…</div>
            </div>
            <!-- Admin: open conversation thread (hidden until chosen) -->
            <div id="chatMessagesArea" style="display:none;flex-direction:column;">
                <div style="padding:6px 12px;font-size:0.8rem;color:#436026;background:#f0f7e6;border-bottom:1px solid #ddecc8;display:flex;align-items:center;gap:6px;">
                    <i class="fa fa-user-circle" style="font-size:1rem;"></i>
                    <span id="chatCurrentUser" style="font-weight:600;"></span>
                </div>
                <div class="chat-messages" id="chatMessages"></div>
                <div id="chatReplyPreview">
                    <div class="reply-preview-inner">
                        <div class="rp-sender" id="chatReplyPreviewSender"></div>
                        <div class="rp-text" id="chatReplyPreviewText"></div>
                    </div>
                    <button class="reply-cancel-btn" onclick="clearReplyTo()" title="Cancel reply">&#x2715;</button>
                </div>
                <div id="chatFilePreview">
                    <img id="chatFileThumb" src="" alt="" style="display:none;">
                    <span class="preview-name" id="chatFilePreviewName"></span>
                    <button class="preview-remove" onclick="clearFilePreview()" title="Remove">&#x2715;</button>
                </div>
                <div class="chat-input-row">
                    <button class="chat-attach-btn" type="button" onclick="document.getElementById('chatFileInput').click()" title="Attach file/image"><i class="fa fa-paperclip"></i></button>
                    <input type="file" id="chatFileInput" style="display:none;" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip" onchange="onChatFileSelected(this)">
                    <input type="text" id="chatInput" placeholder="Type a reply…" onkeydown="if(event.key==='Enter') sendChatMsg()">
                    <button onclick="sendChatMsg()" title="Send reply"><i class="fa fa-paper-plane"></i></button>
                </div>
            </div>
            @else
            <!-- Regular user: direct chat -->
            <div id="chatMessagesArea" style="display:flex;flex-direction:column;">
                <div class="chat-messages" id="chatMessages">
                    <div class="chat-msg received" id="chatWelcomeMsg">
                        Hello! How can I help you today?
                        <div class="chat-time">Finance Department</div>
                    </div>
                </div>
                <div id="chatReplyPreview">
                    <div class="reply-preview-inner">
                        <div class="rp-sender" id="chatReplyPreviewSender"></div>
                        <div class="rp-text" id="chatReplyPreviewText"></div>
                    </div>
                    <button class="reply-cancel-btn" onclick="clearReplyTo()" title="Cancel reply">&#x2715;</button>
                </div>
                <div id="chatFilePreview">
                    <img id="chatFileThumb" src="" alt="" style="display:none;">
                    <span class="preview-name" id="chatFilePreviewName"></span>
                    <button class="preview-remove" onclick="clearFilePreview()" title="Remove">&#x2715;</button>
                </div>
                <div class="chat-input-row">
                    <button class="chat-attach-btn" type="button" onclick="document.getElementById('chatFileInput').click()" title="Attach file/image"><i class="fa fa-paperclip"></i></button>
                    <input type="file" id="chatFileInput" style="display:none;" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip" onchange="onChatFileSelected(this)">
                    <input type="text" id="chatInput" placeholder="Type a message…" onkeydown="if(event.key==='Enter') sendChatMsg()">
                    <button onclick="sendChatMsg()"><i class="fa fa-paper-plane"></i></button>
                </div>
            </div>
            @endif
        </div>
        <button id="floatChatBtn" class="float-fab" title="Chat" onclick="toggleChat()" style="position:relative;">
            <i class="fa fa-comment-dots"></i>
            <span id="chatUnreadBadge"></span>
        </button>
    </div>

</div>

<script>
    // ---- CALENDAR ----
    let calDate = new Date();

    function toggleCalendar() {
        const panel = document.getElementById('floatCalendarPanel');
        panel.classList.toggle('open');
        if (panel.classList.contains('open')) renderCalendar();
    }

    function calChangeMonth(dir) {
        calDate.setMonth(calDate.getMonth() + dir);
        renderCalendar();
    }

    function renderCalendar() {
        const today = new Date();
        const year = calDate.getFullYear();
        const month = calDate.getMonth();
        const label = calDate.toLocaleString('default', { month: 'long', year: 'numeric' });
        document.getElementById('calMonthLabel').textContent = label;

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrev = new Date(year, month, 0).getDate();

        let html = '';
        for (let i = firstDay - 1; i >= 0; i--) {
            html += `<div class="cal-day other-month">${daysInPrev - i}</div>`;
        }
        for (let d = 1; d <= daysInMonth; d++) {
            const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
            const dayOfWeek = new Date(year, month, d).getDay();
            const sunClass = dayOfWeek === 0 ? ' sunday' : '';
            html += `<div class="cal-day${isToday ? ' today' : ''}${sunClass}">${d}</div>`;
        }
        const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
        for (let d = 1; d <= totalCells - firstDay - daysInMonth; d++) {
            html += `<div class="cal-day other-month">${d}</div>`;
        }
        document.getElementById('calGrid').innerHTML = html;
    }

    // ---- CHAT ----
    const CHAT_CSRF     = '{{ csrf_token() }}';
    const CHAT_IS_ADMIN = {{ auth()->user()->role === 'admin' ? 'true' : 'false' }};

    let chatLastId       = 0;       // highest message id loaded
    let chatPollTimer    = null;    // setInterval for live polling
    let chatAdminUserId  = null;    // admin: which user's conversation is open
    let chatConvPollTimer = null;   // setInterval for conversation list refresh
    let chatReplyTo       = null;   // { sender, text } when user clicked reply

    // ---- Admin: go back to conversation list ----
    function chatGoBack() {
        chatAdminUserId = null;
        chatLastId = 0;
        clearInterval(chatPollTimer);
        chatPollTimer = null;
        document.getElementById('chatConversationList').style.display = '';
        document.getElementById('chatMessagesArea').style.display    = 'none';
        const backBtn = document.getElementById('chatBackBtn');
        if (backBtn) backBtn.style.display = 'none';
        loadConversationList();
        // Start conv-list refresh every 5 s
        if (!chatConvPollTimer) {
            chatConvPollTimer = setInterval(loadConversationList, 5000);
        }
    }

    // ---- Admin: load the conversation list ----
    function loadConversationList() {
        fetch('{{ route("chat.messages") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.conversations) renderConversationList(data.conversations);
        })
        .catch(() => {});
    }

    // ---- Admin: open a user conversation ----
    function openAdminConversation(userId, userName, isOnline) {
        chatAdminUserId = userId;
        chatLastId = 0;
        // Stop conv-list refresher, start message poller
        clearInterval(chatConvPollTimer);
        chatConvPollTimer = null;
        document.getElementById('chatConversationList').style.display = 'none';
        const area = document.getElementById('chatMessagesArea');
        area.style.display = 'flex';
        area.style.flexDirection = 'column';
        // Show user name + online dot in the thread header
        const currentUserEl = document.getElementById('chatCurrentUser');
        currentUserEl.innerHTML =
            escapeHtml(userName) +
            ' <span style="display:inline-block;width:9px;height:9px;border-radius:50%;background:' +
            (isOnline ? '#22c55e' : '#9ca3af') + ';margin-left:5px;vertical-align:middle;" title="' +
            (isOnline ? 'Online' : 'Away') + '"></span>';
        const backBtn = document.getElementById('chatBackBtn');
        if (backBtn) backBtn.style.display = 'inline-flex';
        // Clear messages and load fresh
        document.getElementById('chatMessages').innerHTML = '';
        loadChatMessages(true);
        // Start polling for new messages every 3 s
        if (!chatPollTimer) {
            chatPollTimer = setInterval(() => loadChatMessages(false), 3000);
        }
        // Focus input
        const inp = document.getElementById('chatInput');
        if (inp) { setTimeout(() => inp.focus(), 100); }
    }

    function toggleChat() {
        const panel = document.getElementById('floatChatPanel');
        panel.classList.toggle('open');
        if (panel.classList.contains('open')) {
            document.getElementById('chatUnreadBadge').style.display = 'none';
            if (CHAT_IS_ADMIN) {
                if (chatAdminUserId) {
                    // Re-entering an open conversation
                    loadChatMessages(false);
                    if (!chatPollTimer) {
                        chatPollTimer = setInterval(() => loadChatMessages(false), 3000);
                    }
                } else {
                    // Show conversation list
                    loadConversationList();
                    if (!chatConvPollTimer) {
                        chatConvPollTimer = setInterval(loadConversationList, 5000);
                    }
                }
            } else {
                // Regular user
                loadChatMessages(true);
                if (!chatPollTimer) {
                    chatPollTimer = setInterval(() => loadChatMessages(false), 3000);
                }
                const inp = document.getElementById('chatInput');
                if (inp) inp.focus();
            }
        } else {
            clearInterval(chatPollTimer);
            clearInterval(chatConvPollTimer);
            chatPollTimer = null;
            chatConvPollTimer = null;
        }
    }

    function loadChatMessages(initial) {
        if (CHAT_IS_ADMIN && !chatAdminUserId) return; // nothing to load without a selected user
        let url = '{{ route("chat.messages") }}';
        const params = [];
        if (!initial && chatLastId > 0) params.push('after=' + chatLastId);
        if (CHAT_IS_ADMIN && chatAdminUserId) params.push('user_id=' + chatAdminUserId);
        if (params.length) url += '?' + params.join('&');

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (initial) {
                const container = document.getElementById('chatMessages');
                const welcome   = document.getElementById('chatWelcomeMsg');
                container.innerHTML = '';
                if (data.messages.length === 0 && welcome) container.appendChild(welcome);
            }
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    appendChatMsgFromServer(msg);
                    if (msg.id > chatLastId) chatLastId = msg.id;
                });
            }
            // Update Finance Dept online status for regular users
            if (!CHAT_IS_ADMIN && typeof data.admin_online !== 'undefined') {
                const statusEl = document.getElementById('chatOnlineStatus');
                if (statusEl) {
                    statusEl.textContent = data.admin_online ? 'Online' : 'Away';
                    statusEl.style.color  = data.admin_online ? '#86efac' : 'rgba(255,255,255,0.5)';
                }
            }
        })
        .catch(() => {});
    }

    function onChatFileSelected(fileInput) {
        const file = fileInput.files[0];
        if (!file) return;
        const preview  = document.getElementById('chatFilePreview');
        const thumb    = document.getElementById('chatFileThumb');
        const nameEl   = document.getElementById('chatFilePreviewName');
        nameEl.textContent = file.name;
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = e => { thumb.src = e.target.result; thumb.style.display = 'block'; };
            reader.readAsDataURL(file);
        } else {
            thumb.style.display = 'none';
        }
        preview.style.display = 'flex';
    }

    function clearFilePreview() {
        const fi = document.getElementById('chatFileInput');
        if (fi) fi.value = '';
        const thumb = document.getElementById('chatFileThumb');
        if (thumb) { thumb.src = ''; thumb.style.display = 'none'; }
        const nameEl = document.getElementById('chatFilePreviewName');
        if (nameEl) nameEl.textContent = '';
        const preview = document.getElementById('chatFilePreview');
        if (preview) preview.style.display = 'none';
    }

    function setReplyTo(sender, text) {
        chatReplyTo = { sender, text };
        const el = document.getElementById('chatReplyPreview');
        if (el) el.style.display = 'flex';
        const sEl = document.getElementById('chatReplyPreviewSender');
        if (sEl) sEl.textContent = sender;
        const tEl = document.getElementById('chatReplyPreviewText');
        if (tEl) tEl.textContent = text;
        const inp = document.getElementById('chatInput');
        if (inp) inp.focus();
    }

    function clearReplyTo() {
        chatReplyTo = null;
        const el = document.getElementById('chatReplyPreview');
        if (el) el.style.display = 'none';
    }

    function sendChatMsg() {
        const input   = document.getElementById('chatInput');
        const fileInput = document.getElementById('chatFileInput');
        if (!input) return;
        const msg  = input.value.trim();
        const file = fileInput && fileInput.files[0];
        if (!msg && !file) return;
        if (CHAT_IS_ADMIN && !chatAdminUserId) return;

        const fd = new FormData();
        // Prepend reply quote marker if replying
        let fullMsg = msg;
        if (chatReplyTo) {
            fullMsg = '@@REPLY@@' + chatReplyTo.sender + '@@' + chatReplyTo.text + '@@' + msg;
        }
        if (fullMsg)  fd.append('message', fullMsg);
        if (file) fd.append('attachment', file);
        if (CHAT_IS_ADMIN) fd.append('user_id', chatAdminUserId);
        fd.append('_token', CHAT_CSRF);

        input.value = '';
        input.disabled = true;
        clearFilePreview();
        clearReplyTo();

        fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CHAT_CSRF,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: fd
        })
        .then(r => r.json())
        .then(data => {
            if (data.id) {
                appendChatMsgFromServer(data);
                if (data.id > chatLastId) chatLastId = data.id;
            }
            input.disabled = false;
            input.focus();
        })
        .catch(() => { input.disabled = false; });
    }

    function appendChatMsgFromServer(msg) {
        const container = document.getElementById('chatMessages');
        if (!container) return;

        // Parse @@REPLY@@ prefix
        let replyHtml = '';
        let msgText   = msg.message || '';
        const rMatch  = msgText.match(/^@@REPLY@@(.+?)@@(.+?)@@([\s\S]*)$/);
        if (rMatch) {
            replyHtml = '<div class="chat-quote-block">' +
                '<div class="qb-sender">' + escapeHtml(rMatch[1]) + '</div>' +
                '<div class="qb-text">'   + escapeHtml(rMatch[2]) + '</div>' +
                '</div>';
            msgText = rMatch[3];
        }

        const bubble = document.createElement('div');
        bubble.className = 'chat-msg ' + (msg.is_mine ? 'sent' : 'received');
        let html = replyHtml;
        if (msgText) html += escapeHtml(msgText);
        if (msg.attachment_url) {
            if (msg.attachment_type === 'image') {
                html += '<a href="' + escapeHtml(msg.attachment_url) + '" target="_blank">' +
                        '<img class="chat-attachment-img" src="' + escapeHtml(msg.attachment_url) + '" alt="' + escapeHtml(msg.attachment_name || 'image') + '">' +
                        '</a>';
            } else {
                html += '<a class="chat-attachment-file" href="' + escapeHtml(msg.attachment_url) + '" target="_blank">' +
                        '<i class="fa fa-file"></i>' + escapeHtml(msg.attachment_name || 'file') + '</a>';
            }
        }
        const senderLabel = msg.is_mine ? 'You' : (msg.is_admin ? 'Finance Dept.' : msg.sender);
        html += '<div class="chat-time">' +
            escapeHtml(senderLabel) +
            ' &bull; ' + escapeHtml(msg.time) + '</div>';
        bubble.innerHTML = html;

        // Reply button
        const snippetForReply = msgText || (msg.attachment_name ? '\uD83D\uDCCE ' + msg.attachment_name : '\uD83D\uDCCE attachment');
        const replyBtn = document.createElement('button');
        replyBtn.className = 'chat-reply-btn';
        replyBtn.title = 'Reply';
        replyBtn.innerHTML = '<i class="fa fa-reply"></i>';
        replyBtn.onclick = () => setReplyTo(senderLabel, snippetForReply.substring(0, 80));

        // Wrap
        const wrap = document.createElement('div');
        wrap.className = 'chat-msg-wrap ' + (msg.is_mine ? 'sent' : 'received');
        wrap.appendChild(bubble);
        wrap.appendChild(replyBtn);
        container.appendChild(wrap);
        scrollChatToBottom();
    }

    function escapeHtml(str) {
        const d = document.createElement('div');
        d.textContent = String(str);
        return d.innerHTML;
    }

    function renderConversationList(conversations) {
        const list = document.getElementById('chatConversationList');
        if (!list) return;
        list.innerHTML = '';
        if (!conversations || conversations.length === 0) {
            list.innerHTML = '<div style="padding:16px;color:#999;font-size:0.82rem;text-align:center;">No conversations yet</div>';
            return;
        }
        conversations.forEach(conv => {
            const item = document.createElement('div');
            item.style.cssText = 'padding:10px 14px;cursor:pointer;border-bottom:1px solid #f0f0f0;transition:background 0.15s;display:flex;align-items:center;gap:10px;';
            item.innerHTML =
                '<div style="position:relative;width:36px;height:36px;flex-shrink:0;">' +
                '<div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#5a8032,#3a5220);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.95rem;">' +
                escapeHtml(conv.user_name.charAt(0).toUpperCase()) + '</div>' +
                '<span style="position:absolute;bottom:1px;right:1px;width:10px;height:10px;border-radius:50%;background:' + (conv.is_online ? '#22c55e' : '#9ca3af') + ';border:2px solid #fff;"></span>' +
                '</div>' +
                '<div style="flex:1;min-width:0;">' +
                '<div style="display:flex;justify-content:space-between;align-items:center;">' +
                '<span style="font-weight:600;font-size:0.88rem;color:#222;">' + escapeHtml(conv.user_name) + '</span>' +
                '<span style="font-size:0.72rem;color:#999;">' + escapeHtml(conv.last_time) + '</span>' +
                '</div>' +
                '<div style="font-size:0.78rem;color:' + (conv.last_message ? '#777' : '#bbb') + ';white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-style:' + (conv.last_message ? 'normal' : 'italic') + ';">' +
                (conv.last_message ? escapeHtml(conv.last_message) : 'No messages yet — start a conversation') +
                '</div>' +
                '</div>' +
                (conv.unread > 0 ? '<span style="background:#e53935;color:#fff;border-radius:50%;min-width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:0.7rem;padding:0 3px;flex-shrink:0;">' + conv.unread + '</span>' : '');
            item.onmouseenter = () => { item.style.background = '#f5fbee'; };
            item.onmouseleave = () => { item.style.background = ''; };
            item.onclick = () => openAdminConversation(conv.user_id, conv.user_name, conv.is_online);
            list.appendChild(item);
        });
    }

    function scrollChatToBottom() {
        const c = document.getElementById('chatMessages');
        if (c) c.scrollTop = c.scrollHeight;
    }

    // Unread badge — poll every 30 s
    function pollUnreadBadge() {
        fetch('{{ route("chat.unread") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('chatUnreadBadge');
            if (data.unread > 0) {
                badge.textContent = data.unread > 9 ? '9+' : data.unread;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(() => {});
    }
    setInterval(pollUnreadBadge, 30000);
    pollUnreadBadge();

    // Close panels when clicking outside
    document.addEventListener('click', function(e) {
        const chatPanel = document.getElementById('floatChatPanel');
        const chatBtn   = document.getElementById('floatChatBtn');
        const calPanel  = document.getElementById('floatCalendarPanel');
        const calBtn    = document.getElementById('floatCalendarBtn');

        if (chatPanel.classList.contains('open') && !chatPanel.contains(e.target) && !chatBtn.contains(e.target)) {
            chatPanel.classList.remove('open');
        }
        if (calPanel.classList.contains('open') && !calPanel.contains(e.target) && !calBtn.contains(e.target)) {
            calPanel.classList.remove('open');
        }
    });
</script>
