@php
    $user = auth()->user();
    $containerClass = trim('user-indicator ' . ($containerClass ?? ''));
    $containerStyle = $containerStyle ?? null;
@endphp

<div class="{{ $containerClass }}" @if ($containerStyle) style="{{ $containerStyle }}" @endif>
    <div class="price-notification" id="priceNotificationRoot" data-feed-url="{{ route('notifications.price-updates') }}">
        <button type="button" class="price-bell-btn" id="priceBellButton" aria-label="Open price updates">
            <i class="fas fa-bell"></i>
            <span class="price-bell-badge" id="priceBellBadge">0</span>
        </button>

        <div class="price-notification-panel" id="priceNotificationPanel">
            <div class="price-notification-head">
                <span class="price-notification-title">Price Updates</span>
                <span class="price-notification-freshness" id="priceNotificationFreshness">Waiting...</span>
            </div>
            <ul class="price-notification-list" id="priceNotificationList">
                <li class="price-notification-empty">No new price updates yet.</li>
            </ul>
        </div>
    </div>

    <div class="user-info">
        <span class="user-name">{{ $user->name }}</span>
        <span class="user-role">{{ ucwords(str_replace('_', ' ', $user->role)) }}</span>
    </div>
    <a href="{{ route('profile') }}" class="user-avatar">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </a>
</div>

<script>
    (function() {
        if (window.__priceNotificationBellInitialized) {
            return;
        }
        window.__priceNotificationBellInitialized = true;

        const root = document.getElementById('priceNotificationRoot');
        const bellButton = document.getElementById('priceBellButton');
        const badge = document.getElementById('priceBellBadge');
        const panel = document.getElementById('priceNotificationPanel');
        const list = document.getElementById('priceNotificationList');
        const freshness = document.getElementById('priceNotificationFreshness');

        if (!root || !bellButton || !badge || !panel || !list || !freshness) {
            return;
        }

        const feedUrl = root.dataset.feedUrl;
        const storageKey = 'wib_price_notifications_last_seen';
        const cacheKey = 'wib_price_notifications_cache';
        let isOpen = false;
        let latestTimestamp = null;
        let pollTimer = null;
        let isFetching = false;

        function formatCurrency(value) {
            const amount = Number(value || 0);
            return new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP',
                minimumFractionDigits: 2,
            }).format(amount);
        }

        function safeText(text) {
            return String(text || '').replace(/[&<>\"']/g, function(char) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;',
                };

                return map[char] || char;
            });
        }

        function buildDetails(update) {
            const commissionType = String(update.commission_type || 'percentage_based').replace(/_/g, ' ');
            const details = [];

            if (update.commission_rate !== null && update.commission_rate !== undefined) {
                details.push('Rate: ' + Number(update.commission_rate).toFixed(2) + '%');
            }

            if (update.commission_food_amount !== null) {
                details.push('Food: ' + formatCurrency(update.commission_food_amount));
            }

            if (update.commission_drinks_amount !== null) {
                details.push('Drinks: ' + formatCurrency(update.commission_drinks_amount));
            }

            if (update.commission_small_amount !== null) {
                details.push('Small: ' + formatCurrency(update.commission_small_amount));
            }

            if (update.commission_big_amount !== null) {
                details.push('Big: ' + formatCurrency(update.commission_big_amount));
            }

            if (update.commission_mixed_percentage !== null) {
                details.push('Mixed %: ' + Number(update.commission_mixed_percentage).toFixed(2) + '%');
            }

            if (update.commission_mixed_amount !== null) {
                details.push('Mixed amount: ' + formatCurrency(update.commission_mixed_amount));
            }

            return commissionType.charAt(0).toUpperCase() + commissionType.slice(1) + (details.length ? ' | ' + details.join(' | ') : '');
        }

        function renderList(updates) {
            if (!Array.isArray(updates) || updates.length === 0) {
                list.innerHTML = '<li class="price-notification-empty">No new price updates yet.</li>';
                return;
            }

            list.innerHTML = updates.map(function(update) {
                const merchantName = safeText(update.merchant_name || 'Merchant');
                const details = safeText(buildDetails(update));
                const updatedAt = safeText(update.updated_at_display || 'just now');

                return [
                    '<li class="price-notification-item">',
                    '<span class="price-notification-merchant">' + merchantName + '</span>',
                    '<span class="price-notification-details">' + details + '</span>',
                    '<span class="price-notification-time">Updated: ' + updatedAt + '</span>',
                    '</li>'
                ].join('');
            }).join('');
        }

        function updateBadge(count) {
            if (!count || count < 1) {
                badge.textContent = '0';
                badge.classList.remove('visible');
                return;
            }

            badge.textContent = count > 99 ? '99+' : String(count);
            badge.classList.add('visible');
        }

        function markAllAsSeen() {
            if (!latestTimestamp) {
                return;
            }

            localStorage.setItem(storageKey, latestTimestamp);
            updateBadge(0);
        }

        function getLastSeen() {
            return localStorage.getItem(storageKey);
        }

        function setCachedUpdates(updates) {
            localStorage.setItem(cacheKey, JSON.stringify(updates || []));
        }

        function getCachedUpdates() {
            try {
                const cached = localStorage.getItem(cacheKey);
                return cached ? JSON.parse(cached) : [];
            } catch (error) {
                return [];
            }
        }

        function processPayload(payload) {
            const updates = Array.isArray(payload.updates) ? payload.updates : [];
            const lastSeen = getLastSeen();
            latestTimestamp = payload.latest_timestamp || latestTimestamp;

            freshness.textContent = latestTimestamp ? 'Live' : 'No records';

            if (!lastSeen && latestTimestamp) {
                localStorage.setItem(storageKey, latestTimestamp);
                updateBadge(0);
            } else {
                const unreadCount = updates.filter(function(update) {
                    return !!update.updated_at && !!lastSeen && new Date(update.updated_at) > new Date(lastSeen);
                }).length;

                updateBadge(unreadCount);
            }

            if (updates.length > 0) {
                setCachedUpdates(updates);
                renderList(updates);
            } else if (!isOpen) {
                renderList(getCachedUpdates());
            }
        }

        async function fetchUpdates() {
            if (isFetching || !feedUrl) {
                return;
            }

            isFetching = true;
            try {
                const lastSeen = getLastSeen();
                const url = new URL(feedUrl, window.location.origin);
                if (lastSeen) {
                    url.searchParams.set('since', lastSeen);
                }

                const response = await fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to load price notifications');
                }

                const payload = await response.json();
                processPayload(payload || {});
            } catch (error) {
                freshness.textContent = 'Reconnecting...';
            } finally {
                isFetching = false;
            }
        }

        bellButton.addEventListener('click', function(event) {
            event.stopPropagation();
            isOpen = !isOpen;
            panel.classList.toggle('open', isOpen);

            if (isOpen) {
                markAllAsSeen();
                renderList(getCachedUpdates());
            }
        });

        document.addEventListener('click', function(event) {
            if (!root.contains(event.target)) {
                isOpen = false;
                panel.classList.remove('open');
            }
        });

        renderList(getCachedUpdates());
        fetchUpdates();
        pollTimer = window.setInterval(fetchUpdates, 7000);

        window.addEventListener('beforeunload', function() {
            if (pollTimer) {
                window.clearInterval(pollTimer);
            }
        });
    })();
</script>