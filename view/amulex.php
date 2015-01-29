<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Тестовое задание</title>

    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="../assets/vendors/bootstrap-daterangepicker-master/moment.min.js"></script>
    <script type="text/javascript" src="../assets/vendors/bootstrap-daterangepicker-master/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/vendors/bootstrap-daterangepicker-master/daterangepicker-bs3.css" />

    <script src="http://code.highcharts.com/highcharts.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.js"></script>

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
        <div class="navbar-collapse collapse">
            <form id="callsForm" name="callsForm" class="navbar-form navbar-right" role="form">
                <select id="type" name="type" class="form-control">
                    <option value="0">Тип звонка</option>
                    <option value="ANSWER" selected="selected">ANSWER</option>
                    <option value="DOWN">DOWN</option>
                    <option value="INPUT">INPUT</option>
                    <option value="CALLBACK">CALLBACK</option>
                    <option value="CANCEL">CANCEL</option>
                    <option value="BUSY">BUSY</option>
                    <option value="CONGESTION">CONGESTION</option>
                    <option value="CHANUNAVAIL">CHANUNAVAIL</option>
                    <option value="NOANSWER">NOANSWER</option>
                    <option value="INVALIDARGS">INVALIDARGS</option>
                    <option value="BANNED">BANNED</option>
                </select>
                <select id="year" name="year" class="form-control">
                    <option value="0">За год</option>
                    <option value="2015">2015</option>
                    <option value="2014" selected="selected">2014</option>
                    <option value="2013">2013</option>
                    <option value="2012">2012</option>
                    <option value="2011">2011</option>
                    <option value="2010">2010</option>
                    <option value="2009">2009</option>
                    <option value="2008">2008</option>
                    <option value="2007">2007</option>
                    <option value="2006">2006</option>
                    <option value="2005">2005</option>
                </select>
                <div class="form-group">
                    <input id="daterange" name="daterange" type="text" placeholder="Период" class="form-control">
                </div>
                <div class="form-group">
                    <input id="gatway" name="gatway" type="text" placeholder="gatway" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Обновить</button>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</div>

<div class="container chartsBlock" >
    <div class="row">
        <div class="col-md-12">
            <hr />
            <div id="chartYear"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr />
            <div id="chartMonths"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 chartMonthsTable">
            <hr />
            <h2>Таблица со звонками</h2>
            <div id="chartMonthsTable"></div>
        </div>
    </div>
</div>

<div class="footer">
    <p>Тестовое задание</p>
</div>

</body>
</html>