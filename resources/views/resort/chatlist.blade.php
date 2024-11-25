<div class="chat-logo dropdown dropup">
    <!-- Chat Icon with Unread Message Count -->
    <a href="#" id="chatDropdown" data-bs-toggle="dropdown" aria-expanded="false" class="position-relative">
        <i class="fa fa-commenting" aria-hidden="true"></i>
        @if($totalUnreadMessages > 0)
        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" style="bottom: 28px; right: 25px;color:white;">
            {{ $totalUnreadMessages }}
        </span>
        @endif
    </a>

    <!-- Dropdown Menu -->
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chatDropdown" style="width: 300px; right: 0; left: auto;">
        @foreach ($users as $user)
            <li>
                <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('chat', $user->id) }}">
                    <div>
                        @if ($user->unread_messages_count > 0)
                            <b>{{ $user->name }}</b>
                        @else
                            {{ $user->name }}
                        @endif
                    </div>
                    @if ($user->unread_messages_count > 0)
                        <span class="badge bg-danger" style="color: white">{{ $user->unread_messages_count }}</span>
                    @endif
                </a>
            </li>
            @if (!$loop->last)
                <hr class="dropdown-divider">
            @endif
        @endforeach
    </ul>
</div>
