@extends('app.default.layout.base')

@section('script_top')
@parent
<style>
    .sub a:last-child{
        display: block;
        margin-top: 15px;
    }

    .sub a:last-child:after{
        display: block;
          position: relative;
          background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0, pink 100%);
          margin-top: -150px;
          height: 150px;
          width: 100%;
          content: '';
    }

    .sub img, .main img{
        width: 100%;
        display block;
        border-radius: 20px
    }
    .main { width: 65%; float: left; }
    .sub { width: 30%; float: right; }
    .pad-y-15{
        padding: 0 15px;
    }  

    .category{
        margin-top: 1.2em;
    }
    .category::after { 
           content: " ";
           display: block; 
           height: 0; 
           clear: both;
        }
    }

    h1{
        font-family: "Abril Fatface";
            font-size: 26px;
    }

</style>
@stop

@section('content-body')
<div class="wrapper pad-y-15">
    <h1>My Favorites</h1>
</div>
@stop

@section('script_bottom')
@parent

<script type="text/javascript">

$.get('/api/v1/category/favorite', function(resver, statex){
    if(resver.length && statex=='success'){
        $.each(resver, function(i,d){            
            card = $($('#favorite-card').html()).clone();

            $(card).find('[category-name]').text(d.display_name);

            $.each(d.products, function(j,e){
                console.log($(card).find('a:eq('+j+') img').attr('src',e.image));
            });

            $('.wrapper').append(card);
        });
    }
})

</script>


<script type="text/bell-template" id="favorite-card">
    <div class="category">
        <div category-name>Cakes</div>
        <div class="wrap-image">            
            <div class="main">
                <a href=""><img src="//placehold.it/200x200"></a>
            </div>
            <div class="sub">
                <a href=""><img src="//placehold.it/100x100"></a>
                <a href=""><img src="//placehold.it/100x100"></a>
            </div>
        </div>
    </div>
</script>

@stop