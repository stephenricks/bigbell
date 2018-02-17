@extends('app.default.layout.base')
@section('content-body')
<div class="wrapper">
    <div class="wrap">
        <div id="tinderslide" class="loading">
            <ul>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="price" data-price>0</div>
        <div class="title" data-title>title</div>
        <div class="description" data-description>Smarty Plants</div>
    </div>
</div>
@stop