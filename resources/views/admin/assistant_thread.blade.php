@extends('admin.index')

@section('content')
<div class="container-fluid page-content">
    <style>
        .assistant-chat-card {
            background: #1f1f24;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .assistant-chat-header h5 {
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        .thread-messages {
            max-height: 420px;
            overflow-y: auto;
            background: #141419;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
        }
        .thread-msg {
            margin-bottom: 0.9rem;
            padding: 0.6rem 0.9rem;
            border-radius: 12px;
            max-width: 78%;
            box-shadow: 0 2px 6px rgba(0,0,0,0.35);
            font-size: 0.95rem;
        }
        .thread-msg.user {
            background: linear-gradient(135deg, #ff4b6a, #ff214f);
            margin-left: 0;
            color: #fff;
        }
        .thread-msg.admin {
            background: linear-gradient(135deg, #2d6bff, #1b9cff);
            margin-left: auto;
            color: #fff;
        }
        .thread-msg small {
            display: block;
            margin-top: 4px;
            font-size: 0.78rem;
            opacity: 0.9;
        }
        .assistant-reply-form {
            margin-top: 0.5rem;
        }
        .assistant-reply-form input[type="text"] {
            background: #111318;
            border-color: rgba(255,255,255,0.08);
            color: #f8f9fa;
        }
        .assistant-reply-form input[type="text"]::placeholder {
            color: #6c757d;
        }
        .assistant-reply-form .btn-primary {
            background: #ff214f;
            border-color: #ff214f;
            font-weight: 600;
            padding: 0.45rem 1.1rem;
        }
        .assistant-reply-form .btn-primary:hover {
            background: #e30035;
            border-color: #e30035;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card mt-4 assistant-chat-card">
                <div class="card-header d-flex justify-content-between align-items-center assistant-chat-header">
                    <h5 class="mb-0">Chat with <span class="text-info">{{ $user->name }}</span></h5>
                    <a href="{{ route('admin.assistant.conversations') }}" class="btn btn-sm btn-outline-light">← All conversations</a>
                </div>
                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    @endif

                    <div class="thread-messages" id="threadMessages">
                        @forelse($messages as $m)
                            <div class="thread-msg {{ $m->is_from_admin ? 'admin' : 'user' }}">
                                <div>{{ $m->message }}</div>
                                <small>{{ $m->created_at->format('M j, g:i A') }} — {{ $m->is_from_admin ? 'You' : $user->name }}</small>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No messages yet.</p>
                        @endforelse
                    </div>

                    <form action="{{ route('admin.assistant.reply', $user->id) }}" method="POST" class="d-flex gap-2 assistant-reply-form">
                        @csrf
                        <input type="text" name="message" class="form-control" placeholder="Type your reply..." required maxlength="2000">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
