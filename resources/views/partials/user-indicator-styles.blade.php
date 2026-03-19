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

@media (max-width: 768px) {
    .user-indicator {
        width: auto;
        max-width: 100%;
        justify-content: flex-end;
        align-self: flex-end;
    }
}

@media (max-width: 480px) {
    .user-indicator .user-name {
        font-size: 12px;
    }
}