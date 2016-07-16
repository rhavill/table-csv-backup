<!DOCTYPE html>
<html>
<head>
  <title>CSV Backup/Restore</title>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
        integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
    .table-name {
      overflow: hidden;
    }
    .upload-button-container {
      width:150px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="page-header"><h1>CSV Backup/Restore</h1></div>
  <div class="center-block upload-button-container">
    <button type="button" class="btn btn-primary btn-lg btn-block">
      <span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
      Upload CSV
    </button>
  </div>
  @if (count($tables) > 0)
    <ul class="list-group">
      @foreach ($tables as $table)
        <li class="list-group-item">
          <div class="row">
            <div class="col-xs-8 table-name">
              {{ $table }}
            </div>
            <div class="col-xs-4 text-right">
              <a class="btn btn-default btn-xs"
                 href="{{ url('table/'.$table) }}"
                 role="button">
                <span class="glyphicon glyphicon-download" aria-hidden="true">
                </span> Download
              </a>
            </div>
          </div>
        </li>
      @endforeach
    </ul>
  @endif
  {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>--}}
</div>
</body>

</html>