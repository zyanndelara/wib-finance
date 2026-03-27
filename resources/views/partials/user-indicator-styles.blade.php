.user-indicator {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    margin-left: auto;
    width: fit-content;
    max-width: 100%;
    background: rgba(255, 255, 255, 0.85);
    border: 1px solid rgba(67, 96, 38, 0.12);
    border-radius: 999px;
    padding: 6px 8px 6px 16px;
    position: relative;
    z-index: 5400;
}

/* Keep the entire header layer above dashboard cards so dropdown panels are not covered. */
.content-header {
    position: relative;
    z-index: 5000;
    overflow: visible;
}

.user-indicator .user-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #3f633c 0%, #6f954d 100%);
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 18px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 12px rgba(48, 81, 35, 0.36);
}

.user-indicator .user-avatar:hover {
    background: linear-gradient(135deg, #f5d54f 0%, #f5b700 100%);
    color: #1f3624;
    transform: scale(1.06);
    box-shadow: 0 8px 16px rgba(178, 138, 14, 0.34);
}

.user-indicator .user-info {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    text-align: right;
    gap: 2px;
}

.user-indicator .user-name {
    font-weight: 600;
    color: #172118;
    font-size: 14px;
}

.user-indicator .user-role {
    font-size: 12px;
    color: #5b6a56;
    font-weight: 500;
    text-transform: capitalize;
}

.user-indicator .price-notification {
    position: relative;
    display: flex;
    align-items: center;
    z-index: 5200;
}

.user-indicator .price-bell-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1px solid rgba(67, 96, 38, 0.2);
    background: #f8fbe8;
    color: #355124;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.user-indicator .price-bell-btn:hover {
    transform: translateY(-1px);
    background: #eef5e0;
    box-shadow: 0 4px 10px rgba(51, 81, 35, 0.18);
}

.user-indicator .price-bell-btn i {
    font-size: 15px;
}

.user-indicator .price-bell-badge {
    position: absolute;
    top: -4px;
    right: -2px;
    min-width: 18px;
    height: 18px;
    border-radius: 999px;
    background: #b84040;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
    border: 2px solid #fff;
}

.user-indicator .price-bell-badge.visible {
    display: inline-flex;
}

.user-indicator .price-notification-panel {
    position: absolute;
    right: 0;
    top: calc(100% + 10px);
    width: min(370px, 82vw);
    background: #fff;
    border: 1px solid rgba(67, 96, 38, 0.2);
    border-radius: 14px;
    box-shadow: 0 14px 38px rgba(22, 43, 24, 0.22);
    display: none;
    z-index: 5300;
    overflow: hidden;
}

.user-indicator .price-notification-panel.open {
    display: block;
}

.user-indicator .price-notification-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    border-bottom: 1px solid #e5ecda;
    background: linear-gradient(135deg, #f8fbe8 0%, #f0f6e4 100%);
}

.user-indicator .price-notification-title {
    font-size: 13px;
    font-weight: 700;
    color: #263a1f;
}

.user-indicator .price-notification-freshness {
    font-size: 11px;
    font-weight: 600;
    color: #5b6a56;
}

.user-indicator .price-notification-list {
    list-style: none;
    margin: 0;
    padding: 0;
    max-height: 310px;
    overflow-y: auto;
}

.user-indicator .price-notification-item {
    padding: 12px 14px;
    border-bottom: 1px solid #edf2e4;
    display: grid;
    gap: 4px;
}

.user-indicator .price-notification-item:last-child {
    border-bottom: none;
}

.user-indicator .price-notification-merchant {
    font-size: 13px;
    font-weight: 700;
    color: #2f4a28;
}

.user-indicator .price-notification-details {
    font-size: 12px;
    color: #3e4d38;
}

.user-indicator .price-notification-time {
    font-size: 11px;
    color: #6d7d67;
}

.user-indicator .price-notification-empty {
    padding: 18px 14px;
    color: #5b6a56;
    font-size: 12px;
    text-align: center;
}

@media (max-width: 768px) {
    .user-indicator {
        width: auto;
        max-width: 100%;
        justify-content: flex-end;
        align-self: flex-end;
    }

    .user-indicator .price-notification-panel {
        right: -22px;
    }
}

@media (max-width: 480px) {
    .user-indicator .user-name {
        font-size: 12px;
    }
}