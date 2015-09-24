<!doctype html>
<html x-ng-app="boneheadLibrary">

<head>
<meta charset="UTF-8">
<title>Library - The Boneheads :: Northwestern University Marching Band Trombones | Chicago's Big Ten Trombones</title>
<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico"/>
<link rel="stylesheet" type="text/css" href="css/main.css"/>
</head>

<body>
<div x-ng-view=""></div>

<script type="text/javascript" src="lib/angular.min.js"></script>
<script type="text/javascript" src="lib/angular-route.min.js"></script>
<script type="text/javascript" src="lib/angular-animate.min.js"></script>

<script type="text/javascript" src="js/app.js?<? echo rand(); ?>"></script>
<script type="text/javascript" src="js/controllers.js?<? echo rand(); ?>"></script>
<script type="text/javascript" src="js/factories.js?<? echo rand(); ?>"></script>
<script type="text/javascript" src="js/filters.js?<? echo rand(); ?>"></script>
<script type="text/javascript" src="js/directives.js?<? echo rand(); ?>"></script>
</body>

</html>