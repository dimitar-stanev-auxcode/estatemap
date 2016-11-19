@extends('layouts.basemap')

@section('head')
	<link rel="stylesheet" type="text/css" href="/css/estates.css">
	<link rel="stylesheet" type="text/css" href="/css/home.css">
	<link rel="stylesheet" type="text/css" href="/css/custom.css">
@endsection
<?php
    // define photos array
    $photosArray = array();

    // convert photo list to array
    if(!empty($estate->snimki))
    {
        // get photos list from database
        $photosArray = explode(';', $estate->snimki);
        
        // separate main image
        $mainPhoto = $photosArray[0];

        // remove the main image from the rest of the array
        unset($photosArray[0]);
    }
?>

@section('content')
	<div class="container estate-container">
        <div class="row">
            <div class="col-md-12 estate-top">
                <div class="estate-top-inner">
                    <span class="glyphicon glyphicon-home"></span> 
                    <a href="/">Начало</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <a href="/">Имоти</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <a href="/">Под наем</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <a href="/">София</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 estate-data">
                <header class="estate-header">
                    <h1>{{ $title }}</h1>
                </header>
                <section class="estate-inner-main">
                    <div class="row">
                        <div class="col-md-3 left center-on-fall">
                            <span class="estate-value"><span class="glyphicon glyphicon-globe"></span> {{ $estate->grad }}</span>
                        </div>
                        <div class="col-md-3 left center-on-fall">
                            <span class="estate-value"><span class="glyphicon glyphicon-object-align-left"></span> {{ $estate_labels['room_count'] }}</span>
                        </div>
                        <div class="col-md-3 left center-on-fall">
                            <span class="estate-value"><span class="glyphicon glyphicon-lamp"></span> {{ $estate_labels['furnishing'] }}</span>
                        </div>
                        <div class="col-md-3 left center-on-fall">
                            <span class="estate-value"><span class="glyphicon glyphicon-fullscreen"></span> 122 м<sup>2</sup></span>
                        </div>
                    </div>
                </section>
                <section class="estate-inner-secondary">
                    <div class="right">
                        <span class="estate-key-large">
                            @if($estate->tip_sdelka == 'НАЕМ')
                                Наем:
                            @else if($estate->tip_sdelka == 'ПРОДАЖБА')
                                Цена:
                            @endif
                        </span>
                        <span class="estate-value-large">{{ $estate->naem }} EUR</span><br>
                        <span class="estate-value-large-sub">({{ round($estate->naem / $estate->plosht, 2) }} EUR/m<sup>2</sup>)</span>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="estate-breadcumb-heading"><span class="glyphicon glyphicon-info-sign fix-glyphicon"></span> Информация за имот</span>
                        </div>
                    </div>
                    <div class="estate-breadcumb">
                        <!-- квартал/район и етаж -->
                        <div class="row">
                            <div class="col-md-6">
                                <span class="estate-key">Квартал/Район: </span>
                                <span class="estate-value">{{ $estate_labels['region'] }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="estate-key">Етаж: </span>
                                <span class="estate-value">{{ $estate->etaj }}, {{ $estate->etaj_podrobno }}</span>
                            </div>
                        </div>
                        <!-- вид строителство и година -->
                        <div class="row">
                            <div class="col-md-6">
                                <span class="estate-key">Вид строителство: </span>
                                <span class="estate-value">{{ $estate->vid_stroitelstvo }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="estate-key">Година: </span>
                                <span class="estate-value">{{ $estate->godina }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="estate-breadcumb-heading"><span class="glyphicon glyphicon-phone fix-glyphicon"></span> За контакти</span>
                        </div>
                    </div>
                    <div class="estate-breadcumb">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="estate-key">Име: </span>
                                <span class="estate-value">{{ $estate->za_ogled_tursete }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="estate-key">Телефон: </span>
                                <span class="estate-value">{{ $estate->za_ogled_telefon }}</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4 estate-images">
                @if(empty($photosArray))
                    <img src="/images/estates/_no_photo.png" alt="без снимка" />
                @endif
                @if(isset($mainPhoto))
                    <!-- main image -->
                    <div class="row">
                        <div class="col-md-12" style="padding-left: 5px; padding-right: 5px;">
                            <a href="/images/estates/{{ $mainPhoto }}" data-imagelightbox="a"><img src="/images/estates/{{ $mainPhoto }}" /></a>
                        </div>
                    </div>
                    @php
                        // counter for new rows
                        $counter = 0;
                    @endphp
                    @foreach($photosArray as $photo)
                        @if($counter % 2 == 0)
                            <div class="row" style="padding-top: 10px;">
                        @endif
                        <div class="col-md-6" style="padding-left: 5px; padding-right: 5px;">
                            <a href="/images/estates/{{ $photo }}" data-imagelightbox="a"><img src="/images/estates/{{ $photo }}" /></a>
                        </div>
                        <?php
                            // increment counter
                            $counter++;
                        ?>
                        @if($counter % 2 == 0)
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js_footer')

    <script src="/js/plax.js"></script>
    <script src="/js/classie.js"></script>
    <script src="/js/custom.js"></script>
    <script src="/js/loader/loader.js"></script>
    <script src="/js/loader/vendor/modernizr-2.6.2.min.js"></script>
    <!-- image gallery script -->
    <script src="/js/estates.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

    <!-- Core JS file -->
    <script src="/photogallery/photoswipe.min.js"></script> 

    <!-- UI JS file -->
    <script src="/photogallery/photoswipe-ui-default.js"></script>

    <script src="/js/index.js"></script>
@endsection