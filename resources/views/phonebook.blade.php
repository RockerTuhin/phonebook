<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{ asset('public/css/app.css') }}">
</head>
<body>
	<div id="app">
		<Myheader></Myheader>
		<div class="container">
			<router-view></router-view>
		</div>
		<Myfooter></Myfooter>
	</div>

	<script type="text/javascript" src="{{ asset('public/js/app.js') }}"></script>
</body>
</html>