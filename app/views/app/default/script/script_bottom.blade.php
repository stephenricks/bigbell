@section('script_bottom')
<script type="text/javascript" src="/plugins/swipe/js/jquery.min.js"></script>
<script type="text/javascript" src="/plugins/swipe/js/jquery.transform2d.js"></script>
<script type="text/javascript" src="/plugins/swipe/js/jquery.jTinder.js"></script>
<script type="text/javascript" src="/plugins/swipe/js/main.js"></script>
<script>
	var isLogged = {{{ Session::has('user_id')? 'true' : 'false' }}};
</script>
@show