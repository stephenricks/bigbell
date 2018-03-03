@extends('app.default.layout.base')
@section('content-body')
<div class="wrapper">
    <h1>{{ $categoryName }}</h1>
    <div class="wrap">
        <div id="tinderslide" class="loading">
            <ul>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="price" data-price>-</div>
        <div class="title" data-title>-</div>
        <div class="description" data-description>-</div>
    </div>
</div>
@stop

@section('script_bottom')
@parent
<script type="text/javascript" src="/plugins/swipe/js/jquery.transform2d.js"></script>
<script type="text/javascript" src="/plugins/swipe/js/jquery.jTinder.js"></script>
<script type="text/javascript" src="/plugins/swipe/js/main.js"></script>
@stop