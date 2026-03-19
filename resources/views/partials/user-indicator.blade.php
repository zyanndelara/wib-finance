@php
    $user = auth()->user();
    $containerClass = trim('user-indicator ' . ($containerClass ?? ''));
    $containerStyle = $containerStyle ?? null;
@endphp

<div class="{{ $containerClass }}" @if ($containerStyle) style="{{ $containerStyle }}" @endif>
    <div class="user-info">
        <span class="user-name">{{ $user->name }}</span>
        <span class="user-role">{{ ucwords(str_replace('_', ' ', $user->role)) }}</span>
    </div>
    <a href="{{ route('profile') }}" class="user-avatar">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </a>
</div>