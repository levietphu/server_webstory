<script src="{{url('public/frontend')}}/js/bootstrap.bundle.min.js"></script>
<script src="{{url('public/frontend')}}/js/bootstrap.min.js"></script>
<script src="{{url('public/frontend')}}/js/tether.min.js"></script>
<script src="{{url('public/frontend')}}/js/all.min.js"></script>
<script src="{{url('public/frontend')}}/js/owl.carousel.min.js"></script>
<script>
    $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
     nav:false,
            responsive:{
    0:{
         items:1
    },
    600:{
        items:3
            },
    1000:{
        items:5
            }
    }
    })
</script>
<script src="{{url('public/frontend')}}/js/switch-theme.js"></script>
<script src="{{url('public/frontend')}}/js/back-to-top.js"></script>
<script src="{{url('public/frontend')}}/js/list.js"></script>
<script src="{{url('public/frontend')}}/js/ajax-comment.js"></script>

{{-- ajax search chương truyện, phân trang chương truyện --}}
<script src="{{url('public/frontend')}}/js/ajax_chapter.js"></script>
