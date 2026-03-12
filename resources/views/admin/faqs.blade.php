@extends('admin.index')

@section('content')
<div class="container-fluid page-content">
    <style>
        /* FAQ table: ensure readable on dark admin theme */
        .faqs-table th,
        .faqs-table td {
            color: #ffffff !important;
            vertical-align: top;
        }
        .faqs-table thead th {
            border-color: rgba(255, 255, 255, 0.15);
        }
        .faqs-table tbody td {
            border-color: rgba(255, 255, 255, 0.08);
        }
        .faqs-table.table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.03);
        }
        .faqs-table.table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.06);
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Grandiya Assistant (FAQ)</h5>
                </div>
                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="mb-3">Add New FAQ</h6>
                            <form action="{{ route('admin.faqs.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="question">Question</label>
                                    <input type="text" name="question" id="question" class="form-control @error('question') is-invalid @enderror" placeholder="e.g. How do I reserve a table?" required>
                                    @error('question')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="answer">Answer (shown in chatbot)</label>
                                    <textarea name="answer" id="answer" rows="4" class="form-control @error('answer') is-invalid @enderror" placeholder="Short, helpful answer for this question."></textarea>
                                    @error('answer')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Save FAQ</button>
                            </form>
                        </div>

                        <div class="col-md-8">
                            <h6 class="mb-3">Existing FAQs</h6>
                            @if($faqs->isEmpty())
                                <p class="text-muted">No FAQs yet. Use the form on the left to add your first question.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover faqs-table">
                                        <thead>
                                            <tr>
                                                <th>Question</th>
                                                <th>Answer</th>
                                                <th style="width: 120px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($faqs as $faq)
                                                <tr>
                                                    <td style="white-space: normal; word-break: break-word;">
                                                        <div class="font-weight-bold {{ trim($faq->question) === 'What payment methods do you accept?' ? 'text-white' : '' }}">
                                                            {{ $faq->question }}
                                                        </div>
                                                    </td>
                                                    <td style="white-space: normal; word-break: break-word;">
                                                        <div class="{{ trim($faq->question) === 'What payment methods do you accept?' ? 'text-white' : '' }}">
                                                            {!! nl2br(e($faq->answer)) !!}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-primary mr-1"
                                                                    data-toggle="modal"
                                                                    data-target="#faqEditModal{{ $faq->id }}"
                                                                    data-faq-edit="{{ $faq->id }}">
                                                                Edit
                                                            </button>
                                                            <a href="{{ route('admin.faqs.delete', $faq->id) }}"
                                                               class="btn btn-sm btn-danger"
                                                               onclick="return confirm('Delete this FAQ?');">
                                                                Delete
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Render modals outside .table-responsive to avoid focus/click issues --}}
                                @foreach($faqs as $faq)
                                    <div class="modal fade" id="faqEditModal{{ $faq->id }}" tabindex="-1" role="dialog" aria-labelledby="faqEditModalLabel{{ $faq->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="faqEditModalLabel{{ $faq->id }}">Edit FAQ</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Question</label>
                                                            <input type="text" name="question" value="{{ $faq->question }}" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Answer</label>
                                                            <textarea name="answer" rows="6" class="form-control" placeholder="Answer shown in chatbot...">{{ $faq->answer }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fallback: if Bootstrap's data-api isn't firing on this page,
    // force-open the modal AFTER admin scripts (jQuery/Bootstrap) load.
    window.addEventListener('load', function () {
        var $ = window.jQuery;
        if (!$ || !$.fn) return;

        // Auto-dismiss flash alerts after a short delay
        setTimeout(function () {
            $('.alert.alert-dismissible').alert('close');
        }, 3000);

        $(document).on('click', '[data-faq-edit]', function () {
            // If Bootstrap data-api worked, modal will already be open; this is harmless.
            var id = $(this).data('faq-edit');
            var $modal = $('#faqEditModal' + id);
            if ($modal.length === 0) return;

            // Ensure modal isn't trapped in overflow/stacking contexts
            if ($modal.parent()[0] !== document.body) {
                $modal.appendTo(document.body);
            }

            if (typeof $modal.modal === 'function') {
                $modal.modal('show');
            }

            setTimeout(function () {
                $modal.find('input[name="question"]').trigger('focus');
            }, 200);
        });
    });
</script>
@endsection

