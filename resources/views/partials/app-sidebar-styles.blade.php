/* Sidebar Styles */
.sidebar {
    width: 230px;
    background: linear-gradient(180deg, #223a28 0%, #2d4a30 55%, #263f2a 100%);
    color: white;
    display: flex;
    flex-direction: column;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    box-shadow: 6px 0 30px rgba(20, 35, 23, 0.34);
    z-index: 1000;
}

.sidebar-logo {
    padding: 20px 16px 18px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.16);
}

.sidebar-logo img {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.sidebar-logo img:hover {
    transform: scale(1.07);
}

.sidebar-logo .app-name {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.8);
}

.sidebar-menu {
    flex: 1;
    padding: 10px 10px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.sidebar-menu::-webkit-scrollbar {
    width: 4px;
}

.sidebar-menu::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-menu::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
}

.menu-section-label {
    font-size: 9.5px;
    font-weight: 700;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.38);
    padding: 10px 8px 4px;
    user-select: none;
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 10px;
    color: rgba(255, 255, 255, 0.78);
    text-decoration: none;
    transition: all 0.22s ease;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    font-size: 12.5px;
    font-weight: 500;
    border-radius: 10px;
}

.menu-item .menu-icon {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    background: rgba(255, 255, 255, 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    flex-shrink: 0;
    transition: all 0.22s ease;
    color: rgba(255, 255, 255, 0.7);
}

.menu-item:hover {
    background: rgba(255, 255, 255, 0.12);
    color: white;
    transform: translateX(2px);
}

.menu-item:hover .menu-icon {
    background: rgba(255, 211, 0, 0.18);
    color: #ffd300;
}

.menu-item.active {
    background: rgba(255, 211, 0, 0.14);
    color: #ffd300;
    font-weight: 700;
}

.menu-item.active .menu-icon {
    background: #ffd300;
    color: #2d4016;
}

.menu-divider {
    height: 1px;
    background: rgba(255, 255, 255, 0.07);
    margin: 8px 4px;
}

.sidebar-footer {
    padding: 12px 10px 14px;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    background: rgba(0, 0, 0, 0.15);
}

.logout-btn {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 8px 10px;
    background: rgba(255, 80, 80, 0.1);
    color: rgba(255, 150, 150, 0.9);
    border: 1px solid rgba(255, 80, 80, 0.2);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.22s ease;
    width: 100%;
    font-size: 12.5px;
    font-weight: 600;
}

.logout-btn .menu-icon {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    background: rgba(255, 80, 80, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    flex-shrink: 0;
    transition: all 0.22s ease;
}

.logout-btn:hover {
    background: rgba(255, 80, 80, 0.22);
    border-color: rgba(255, 80, 80, 0.5);
    color: #ff6b6b;
    transform: translateX(2px);
}

.logout-btn:hover .menu-icon {
    background: rgba(255, 80, 80, 0.3);
}

/* Mobile Menu Toggle */
.mobile-menu-toggle {
    display: none;
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1100;
    background: #3f633c;
    color: white;
    border: none;
    padding: 12px 15px;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 8px 16px rgba(24, 43, 22, 0.25);
    transition: all 0.3s ease;
}

.mobile-menu-toggle:hover {
    background: #6f954d;
    transform: scale(1.05);
}

.mobile-menu-toggle i {
    font-size: 20px;
}

/* Mobile Overlay */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.sidebar-overlay.active {
    display: block;
    opacity: 1;
}
