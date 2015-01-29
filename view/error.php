<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?= $error ?></title>

    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="../assets/js/charts.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Тестовое задание - построение графиков</a>
        </div>
    </div>
</div>

<div class="container chartsBlock" >
    <div class="row">
        <div class="col-md-12">
            <div class="error-title">Ошибка:</div>
            <div class="error"><?= $error ?></div>
        </div>
    </div>
</div>

<div class="footer">
    <p>Тестовое задание</p>
</div>

</body>
</html>