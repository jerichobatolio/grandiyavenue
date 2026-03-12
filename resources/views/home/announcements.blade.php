<!-- Announcements Section -->
@if(isset($announcements) && $announcements->count() > 0)
<div id="announcements" class="container-fluid py-5 wow fadeIn" style="background: #000;">
    <div class="container">
        <h2 class="section-title text-center py-4 mb-5" style="color: white !important;">
            <i class="fa fa-bullhorn"></i> Announcements
        </h2>
        
        <style>
            .announcements-carousel {
                max-width: 900px;
                margin: 0 auto;
            }
            
            .announcement-card {
                background: #000;
                border-radius: 15px;
                padding: 16px 18px;
                margin: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            
            .announcement-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 40px rgba(0,0,0,0.3);
            }
            
            .announcement-content {
                color: #ffffff;
                line-height: 1.6;
                font-size: 0.85rem;
                word-wrap: break-word;
                margin-bottom: 10px;
                text-align: left;
            }
            
            .announcement-content p {
                margin-bottom: 8px;
            }
            
            .announcement-content br {
                display: block;
                content: "";
                margin-top: 8px;
            }
            
            .announcement-image-wrapper {
                text-align: center;
                margin: 12px 0;
            }
            
            .announcement-image-wrapper img {
                max-width: 100%;
                max-height: 400px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }
            
            .announcement-date {
                color: #cccccc;
                font-size: 0.75rem;
                margin-top: 10px;
                padding-top: 10px;
                border-top: 1px solid #333333;
            }
            
            .announcement-date i {
                margin-right: 5px;
            }
            
            /* Carousel styling */
            .carousel-indicators {
                bottom: -50px;
            }
            
            .carousel-indicators button {
                background-color: rgba(255,255,255,0.5);
                width: 12px;
                height: 12px;
                border-radius: 50%;
                margin: 0 5px;
                border: none;
                padding: 0;
            }
            
            .carousel-indicators button.active {
                background-color: white;
            }
            
            .carousel-control-prev,
            .carousel-control-next {
                width: 50px;
                height: 50px;
                top: 50%;
                transform: translateY(-50%);
                background-color: rgba(255,255,255,0.2);
                border-radius: 50%;
                opacity: 0.8;
            }
            
            .carousel-control-prev:hover,
            .carousel-control-next:hover {
                opacity: 1;
                background-color: rgba(255,255,255,0.3);
            }
            
            .carousel-control-prev {
                left: -25px;
            }
            
            .carousel-control-next {
                right: -25px;
            }
        </style>
        
        <div id="announcementsCarousel" class="carousel slide announcements-carousel" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($announcements as $index => $announcement)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="announcement-card">
                            <div class="announcement-content">
                                {!! nl2br(e($announcement->content)) !!}
                            </div>
                            
                            @if($announcement->image)
                                <div class="announcement-image-wrapper">
                                    <img src="{{ asset('assets/imgs/' . $announcement->image) }}" alt="Announcement Image">
                                </div>
                            @endif
                            
                            <div class="announcement-date">
                                <i class="fa fa-calendar"></i> 
                                Posted on {{ $announcement->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($announcements->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#announcementsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#announcementsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                
                <div class="carousel-indicators">
                    @foreach($announcements as $index => $announcement)
                        <button type="button" data-bs-target="#announcementsCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endif
