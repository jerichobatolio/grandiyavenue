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

</body>
</html>
