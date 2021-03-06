<div id="myCarousel" class="carousel slide company-about-carousel">
    <!-- 轮播（Carousel）指标 -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <!-- 轮播（Carousel）项目 -->
    <div class="carousel-inner">
        <div class="item active">
            <img src="{{ asset('assets/images/company/slide/slide_1.jpg') }}" alt="First slide">
            <div class="carousel-caption">标题 1 欢迎访问XXX有限公司</div>
        </div>
        <div class="item">
            <img src="{{ asset('assets/images/company/slide/slide_2.jpeg') }}" alt="Second slide">
            <div class="carousel-caption">标题 2 欢迎访问XXX有限公司</div>
        </div>
        <div class="item">
            <img src="{{ asset('assets/images/company/slide/slide_3.jpg') }}" alt="Third slide">
            <div class="carousel-caption">标题 3 欢迎访问XXX有限公司</div>
        </div>
    </div>
    <!-- 轮播（Carousel）导航 -->
    <a class="carousel-control left" href="#myCarousel"
       data-slide="prev"></a>
    <a class="carousel-control right" href="#myCarousel"
       data-slide="next"></a>
</div>