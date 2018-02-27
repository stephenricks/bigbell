@extends('app.default.layout.base')

@section('script_top')
@parent
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script>

  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      console.log(response);
      $.post('/fb/login', {response:response}, function(resver){

          if(resver.redirectUrl){
            location = resver.redirectUrl;
          }

      });

    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{{{ getenv('FB_APPID') }}}',
      cookie     : true,
      xfbml      : true,
      version    : 'v2.12'  
    });
      
    FB.AppEvents.logPageView();   

  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId={{{ getenv('FB_APPID') }}}';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
<style>
  #login{
    display: block;
    margin: 0 auto;
    text-align: center;
    margin-top: 20vh;
  }
</style>
@stop

@section('content-body')
<div id="fb-root"></div>

<div id="login" class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false" data-scope="public_profile,email" onlogin="checkLoginState();"></div>
@stop


@section('script_bottom')
@overwrite