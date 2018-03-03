
<script>
var isLogged = {{{ Session::has('user_id')? 'true' : 'false' }}};
</script>

@section('script_bottom')
<script type="text/javascript" src="/plugins/swipe/js/jquery.min.js"></script>
@show