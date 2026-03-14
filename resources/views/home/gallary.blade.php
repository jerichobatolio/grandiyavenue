<div id="gallary" class="container-fluid bg-dark text-light py-3 text-center wow fadeIn" style="padding-top: 1.35rem; padding-bottom: 0.9rem; margin-top: 0.9rem;">
    <style>
        #gallary .section-title {
            color: white !important;
            font-size: 2.6rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0;
        }
    </style>
    <h2 class="section-title mb-0">Our Menu</h2>
</div>

<div class="gallary row" style="margin-top: 10px; margin-bottom: 60px;">
    @if(isset($galleries) && $galleries->count() > 0)
        {{-- Show dynamic images from database --}}
        @foreach($galleries as $gallery)
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                     alt="{{ $gallery->title ?? 'Gallery Image' }}" 
                     class="gallary-img"
                     title="{{ $gallery->description ?? $gallery->title ?? 'Gallery Image' }}">
            </div>
        @endforeach
    @endif
</div>
