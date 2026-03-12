    <style>
        /* Improved Footer Typography */
        #contact h3, 
        .container-fluid.bg-dark h3 {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            text-transform: uppercase;
        }
        
        #contact p,
        .container-fluid.bg-dark p {
            font-size: 1.1rem;
            font-weight: 500;
            line-height: 1.8;
            color: #e0e0e0;
        }
        
        #contact .text-muted,
        .container-fluid.bg-dark .text-muted {
            font-size: 1.05rem;
            font-weight: 500;
            color: #d0d0d0 !important;
            line-height: 2;
        }
        
        .bg-dark.text-light {
            font-weight: 500;
        }
    </style>
    
    <div id="contact" class="container-fluid bg-dark text-light border-top wow fadeIn">
        <div class="row">
            <div class="col-md-6 px-0">
                <iframe src="https://www.google.com/maps?q=Aroma+Center,+Gate+1+San+Roque,+San+Jose,+Occidental+Mindoro+5100+Philippines&output=embed" width="100%" height="100%" style="border:0; min-height: 400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-md-6 px-5 has-height-lg middle-items">
                <h3>FIND US</h3>
                <p>We welcome you to the Grandiya Resto Bar, a highly-rated spot with a 4.2-star average.</p>
                
                <h4 class="mt-4 mb-2" style="color: white; font-size: 1.3rem; font-weight: 600;">📍 Our Location</h4>
                <p>You can find us conveniently located in the municipality of San Jose, Occidental Mindoro, Philippines. For the most precise navigation, use the Plus Code: <strong>926V+626</strong>.</p>
                
                <h4 class="mt-4 mb-2" style="color: white; font-size: 1.3rem; font-weight: 600;">🕐 Operating Hours</h4>
                <p>We are here to serve you seven nights a week! Our doors open every day from Monday to Sunday, running late from 10:00 AM until 9:00 PM.</p>
                
                <div class="text-muted mt-3">
                  
                </div>
            </div>
        </div>
    </div>

    <!-- page footer  -->
    <div class="container-fluid bg-dark text-light has-height-md middle-items border-top text-center wow fadeIn">
        <div class="row">
            <div class="col-sm-4">
                <h3>EMAIL US</h3>
                <P class="text-muted">Grandiya@gmail.com</P>
            </div>
            <div class="col-sm-4">
                <h3>CALL US</h3>
                <P class="text-muted">09166452031</P>
            </div>
            <div class="col-sm-4">
                <h3>FIND US</h3>
                <P class="text-muted">San Jose Philippines, 5100</P>
            </div>
        </div>
    </div>

    <!-- end of page footer -->

    <!-- REVIEWS Section in Footer -->
    <div class="container-fluid bg-dark text-light border-top wow fadeIn py-5">
        <div class="container">
            <h2 class="section-title my-5 text-center" style="font-size: 2.5rem; font-weight: 700; text-transform: uppercase; color: #ffffff; text-shadow: 0 2px 8px rgba(0,0,0,0.3); letter-spacing: 2px; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility;">
                <span style="position: relative; z-index: 1; display: inline-block;">⭐ CUSTOMER REVIEWS ⭐</span>
            </h2>
            
            <!-- Review Submission Form -->
            <div class="row mb-5">
                <div class="col-md-8 offset-md-2">
                    <div class="card bg-transparent border" style="border-color: rgba(255,255,255,0.2) !important;">
                        <div class="card-body p-4">
                            <h4 class="text-center mb-4" style="color: #fff;">Share Your Experience</h4>
                            <form id="reviewForm" method="POST" action="{{ route('submit_review') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label" style="color: #e0e0e0;">Your Name</label>
                                    <input type="text" class="form-control bg-dark text-light border-secondary" id="customer_name" name="customer_name" required style="color: #fff;">
                                </div>
                                <div class="mb-3">
                                    <label for="customer_email" class="form-label" style="color: #e0e0e0;">Your Email (Optional)</label>
                                    <input type="email" class="form-control bg-dark text-light border-secondary" id="customer_email" name="customer_email" style="color: #fff;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" style="color: #e0e0e0;">Your Rating</label>
                                    <div class="star-rating-input" style="font-size: 2rem; cursor: pointer; text-align: center;">
                                        <span class="star" data-rating="1" style="color: #666; margin: 0 5px;">☆</span>
                                        <span class="star" data-rating="2" style="color: #666; margin: 0 5px;">☆</span>
                                        <span class="star" data-rating="3" style="color: #666; margin: 0 5px;">☆</span>
                                        <span class="star" data-rating="4" style="color: #666; margin: 0 5px;">☆</span>
                                        <span class="star" data-rating="5" style="color: #666; margin: 0 5px;">☆</span>
                                    </div>
                                    <input type="hidden" name="rating" id="rating" required>
                                    <div id="rating-text" class="text-center mt-2" style="color: #ffc107; font-weight: 600;"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label" style="color: #e0e0e0;">Your Review (Optional)</label>
                                    <textarea class="form-control bg-dark text-light border-secondary" id="description" name="description" rows="3" style="color: #fff;" placeholder="Tell us about your experience..."></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit Review</button>
                                </div>
                            </form>
                            <div id="review-message" class="mt-3 text-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .star-rating-input .star {
            transition: all 0.2s;
        }
        .star-rating-input .star:hover,
        .star-rating-input .star.active {
            color: #ffc107 !important;
            transform: scale(1.2);
        }
    </style>

    <script>
        // Interactive Star Rating
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-rating-input .star');
            const ratingInput = document.getElementById('rating');
            const ratingText = document.getElementById('rating-text');
            const reviewForm = document.getElementById('reviewForm');
            const reviewMessage = document.getElementById('review-message');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    ratingInput.value = rating;
                    
                    // Update star display
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.textContent = '★';
                            s.classList.add('active');
                        } else {
                            s.textContent = '☆';
                            s.classList.remove('active');
                        }
                    });

                    // Update rating text
                    const ratingLabels = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
                    ratingText.textContent = ratingLabels[rating] || '';
                });

                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.style.color = '#ffc107';
                        } else {
                            s.style.color = '#666';
                        }
                    });
                });
            });

            // Reset stars on mouse leave (if no rating selected)
            document.querySelector('.star-rating-input').addEventListener('mouseleave', function() {
                if (!ratingInput.value) {
                    stars.forEach(s => {
                        s.style.color = '#666';
                    });
                }
            });

            // Handle form submission
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!ratingInput.value) {
                    reviewMessage.innerHTML = '<div class="alert alert-warning">Please select a rating!</div>';
                    return;
                }

                // Submit via AJAX
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        reviewMessage.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                        reviewForm.reset();
                        ratingInput.value = '';
                        ratingText.textContent = '';
                        stars.forEach(s => {
                            s.textContent = '☆';
                            s.classList.remove('active');
                            s.style.color = '#666';
                        });
                    } else {
                        reviewMessage.innerHTML = '<div class="alert alert-danger">' + (data.message || 'An error occurred. Please try again.') + '</div>';
                    }
                })
                .catch(error => {
                    // If not JSON response, reload page
                    window.location.reload();
                });
            });
        });
    </script>

	<!-- core  -->
    <script src="{{ asset('assets/vendors/jquery/jquery-3.4.1.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- bootstrap affix -->
    <script src="{{ asset('assets/vendors/bootstrap/bootstrap.affix.js') }}"></script>

    <!-- wow.js -->
    <script src="{{ asset('assets/vendors/wow/wow.js') }}"></script>
    
    <!-- google maps (using iframe instead) -->
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtme10pzgKSPeJVJrG1O3tjR6lk98o4w8&callback=initMap"></script> -->
    <!-- Foodhut js -->
         <div class="bg-dark text-light text-center border-top wow fadeIn">
        <p class="mb-0 py-3 text-muted small">&copy; Copyright <script>document.write(new Date().getFullYear())</script> Made with <i class="ti-heart text-danger"></i> By <a href="http://devcrud.com">Batolio,Peralta</a></p>
    </div>
    <script src="{{ asset('assets/js/Foodhut.js') }}"></script>