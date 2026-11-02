@extends('layouts.app')

@section('title', 'Notifications')

@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Notifications</h4>
            <p class="text-muted mb-0">
                View all your latest notifications.
            </p>
        </div>

        {{-- Mark All As Read --}}
        @if ($unreadCount > 0)
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                @method('PATCH')

                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-check2-all me-1"></i>
                    Mark All As Read
                </button>
            </form>
        @endif
    </div>

    {{-- Notification List --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">

            @forelse ($notifications as $notification)

                <div class="d-flex align-items-start justify-content-between p-3 border-bottom
                    {{ is_null($notification->read_at) ? 'bg-light' : '' }}">

                    <div class="d-flex gap-3">

                        <div class="rounded-circle d-flex align-items-center justify-content-center
                            bg-primary-subtle text-primary"
                            style="width: 42px; height: 42px; flex-shrink: 0;">

                            <i class="bi bi-bell fs-5"></i>
                        </div>

                        <div>
                            <h6 class="fw-semibold mb-1">
                                {{ $notification->data['title'] ?? 'Notification' }}
                            </h6>

                            <p class="text-muted mb-1">
                                {{ $notification->data['message'] ?? '' }}
                            </p>

                            <small class="text-muted">
                                {{ $notification->created_at->format('d M Y, h:i A') }}
                            </small>
                        </div>
                    </div>

                    <div>
                        @if (is_null($notification->read_at))
                            <form action="{{ route('notifications.read', $notification->id) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    class="btn btn-sm btn-outline-primary">
                                    Mark as Read
                                </button>
                            </form>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">
                                Read
                            </span>
                        @endif
                    </div>

                </div>

            @empty

                <div class="text-center py-5">
                    <i class="bi bi-bell-slash fs-1 text-muted"></i>

                    <h6 class="mt-3">No Notifications</h6>

                    <p class="text-muted mb-0">
                        You don't have any notifications yet.
                    </p>
                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($notifications->hasPages())
            <div class="card-footer bg-white border-0 p-3">
                {{ $notifications->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
