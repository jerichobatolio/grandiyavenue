@extends('admin.index')

@section('content')
<div class="container-fluid page-content">
    <style>
        .assistant-table th, .assistant-table td { color: #fff !important; vertical-align: middle !important; }
        .assistant-table thead th { border-color: rgba(255,255,255,0.15); }
        .assistant-table tbody td { border-color: rgba(255,255,255,0.08); }
        .assistant-table tbody tr:hover { background-color: rgba(255,255,255,0.06); }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Assistant Conversations (Customer chat)</h5>
                    <a href="{{ route('admin.faqs') }}" class="btn btn-sm btn-outline-light">Back to FAQs</a>
                </div>
                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    @endif

                    @if($users->isEmpty())
                        <p class="text-muted mb-0">No conversations yet. Customers will appear here when they send a message from the Grandiya Assistant chat on the site.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover assistant-table">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Last message</th>
                                        <th>Time</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $u)
                                        @php
                                            $last = $lastMessageByUser[$u->id] ?? null;
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $u->name }}</strong>
                                                @if($u->email)
                                                    <br><small class="text-muted">{{ $u->email }}</small>
                                                @endif
                                                @if($last && !$last->is_from_admin)
                                                    <span class="badge badge-warning ml-1">New</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($last)
                                                    <span class="{{ $last->is_from_admin ? 'text-info' : '' }}">{{ Str::limit($last->message, 50) }}</span>
                                                    @if($last->is_from_admin)<small class="text-muted">(you)</small>@endif
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>
                                                @if($last)
                                                    <small>{{ $last->created_at->diffForHumans() }}</small>
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('admin.assistant.thread', $u->id) }}" class="btn btn-sm btn-primary mr-2">Open chat</a>
                                                <form action="{{ route('admin.assistant.conversation.delete', $u->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this conversation? This will remove all messages for this customer.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
