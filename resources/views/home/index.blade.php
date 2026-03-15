<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	@include('home.css')
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    
    @include('home.header')
    

   @include('home.about')

    <!--  gallary Section  -->
   

    @include('home.gallary')
    <!-- book a table Section  -->
    @include('home.book')
    
    <!-- Book Event Section  -->
    @include('home.book_event_section')
    
    <!-- BLOG Section  -->
   @include('home.blog')

    <!-- Announcements Section (after Food Categories) -->
    @include('home.announcements')

    <!-- REVIEWS Section  -->
    

   
    @include('home.footer')

    {{-- Scroll to blog section when URL has #blog (e.g. from Cart "Browse Menu" / "Add More Items") --}}
    <script>
    (function() {
        if (window.location.hash !== '#blog') return;
        if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
        function scrollToBlog() {
            var el = document.getElementById('blog');
            if (!el) return;
            var navbar = document.querySelector('.custom-navbar');
            var offset = (navbar && navbar.offsetHeight) ? navbar.offsetHeight + 20 : 80;
            var y = el.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo(0, Math.max(0, y));
        }
        scrollToBlog();
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                scrollToBlog();
                setTimeout(scrollToBlog, 250);
                setTimeout(scrollToBlog, 600);
            });
        }
        window.addEventListener('load', function() {
            setTimeout(scrollToBlog, 100);
            setTimeout(scrollToBlog, 500);
        });
    })();
    </script>

</body>
</html>
