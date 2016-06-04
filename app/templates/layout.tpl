<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>MagImport :: Importeer magazines snel en goedkoop!</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <link href="{{$rootDir}}/css/screen.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="{{$rootDir}}/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="{{$rootDir}}/js/app.js"></script>
</head>

<body>
    <div id="container">
        <a href="#content" id="gotocontent">Jump to content</a>
    	<a href="{{$root}}" id="logo">MagImport</a>

    	<ul id="menu">
    		<li><a href="{{$root}}">Home</a></li>
    		<li><a href="{{$root}}/products">Producten</a></li>
        	<li><a href="{{$root}}/cart">Winkelmand(<span id="cart-amount">{{count($cart)}}</span>)</a></li>
        </ul>

        {{$search}}

        <div id="userpanel">
        	{{$userpanel}}
        </div>

        <div class="clearfix"></div>
        <div id="content">
            {{$content}}
        </div>
    </div>
</body>

</html>
