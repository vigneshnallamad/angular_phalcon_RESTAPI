<!DOCTYPE html>
<html data-ng-app="userApp">
<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="/"/>
    <title>The User App</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/app.css"/>
</head>
<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" ui-sref="users">The User App</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a ui-sref="users">Home</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row top-buffer">
            <div class="col-xs-8 col-xs-offset-2">
                <div ui-view></div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="lib/jquery.min.js"></script>
    <script type="text/javascript" src="lib/angular.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/controllers.js"></script>
    <script type="text/javascript" src="js/services.js"></script>
    <script type="text/javascript" src="lib/angular-ui-router.min.js"></script>
    <script type="text/javascript" src="lib/angular-resource.min.js"></script>
</body>
</html>