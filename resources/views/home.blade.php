@extends('layouts.basemap')

@section('head')
<link rel="stylesheet" type="text/css" href="/css/home.css">
<link rel="stylesheet" type="text/css" href="/css/custom.css">
    <style>
      
      #map {
        width: 100%;
        height: 90vh;
      }
    </style>
    
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        
        <div id="info_modal">
                    
        </div><!-- Info Modal -->
                    <div class="jumbotron jumbotron-fluid" id="filter_section">
                        <div class="row">
                            <div class="contrainer"> 
                                <div class="row">
                                    <div class="col-md-2">

                                        <label for="sel1">Град</label>
                                          <select class="form-control" id="sel1">
                                            <option>София</option>
                                            <option>София</option>
                                            <option>София</option>
                                            <option>София</option>
                                          </select>
                                        
                                    </div>    
                                    <div class="col-md-2">
                                        <label for="sel1">Квартал</label>
                                          <select class="form-control" id="sel1">
                                            <option>Лозенец</option>
                                            <option>Люлин</option>
                                            <option>Младост</option>
                                          </select>
                                        
                                    </div>
                                    <div class="col-md-2">
                                        <label for="sel1">Стаи</label>
                                          <select class="form-control" id="sel1">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                          </select>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div id="sliderDouble" class="slider slider-info"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div id="map"></div>
                  


                    

    </div>
</div>
<div id="circle_div" style="display: none;">
    <svg  height="400" width="400" id="preloader">
      <g filter="url(#goo)">
        <circle class="outer" cx="200" cy="200" r="150" />
        <circle class="drop" cx="200" cy="200" r="15">
      </g>

      <defs>
        <filter id="goo">
          <feGaussianBlur in="SourceGraphic" stdDeviation="8" result="blur" />
          <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo" />

        </filter>
      </defs>
    </svg>
</div>
<input type="hidden" id="ajax_callback_storage" value="">
@endsection

@section('js_footer')

    <script src="/js/custom.js"></script>
    <script src="/js/loader/loader.js"></script>
    <script src="/js/loader/vendor/modernizr-2.6.2.min.js"></script>

    <script type="text/javascript">
      @if(isset($estatesJson))
        var estatesJSON='{!! $estatesJson !!}';
      @endif
    </script>
    <script src="/js/index.js"></script>
@endsection