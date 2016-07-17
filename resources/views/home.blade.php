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
  <link href="/ricardo/fine-uploader/fine-uploader.css" rel="stylesheet" type="text/css"/>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
    .table-name {
      overflow: hidden;
    }
    #upload-inputs-container {
      width:330px;
      margin-bottom: 10px;
    }
    #upload-button-container {
      padding-left: 0;
    }
    #upload-text-container {
      padding-right: 10px;
    }
    .qq-upload-button-hover {
      background: none;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="page-header"><h1>CSV Backup/Restore</h1></div>
  <div id="fine-uploader"></div>
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
  <script type="text/javascript" src="/ricardo/fine-uploader/fine-uploader.min.js"></script>
  <script type="text/template" id="qq-template">
    <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
      <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
      </div>
      <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
        <span class="qq-upload-drop-area-text-selector"></span>
      </div>
      <div id="upload-inputs-container" class="center-block row">
        <div id="upload-text-container" class="col-xs-7">
          <input type="text" class="form-control" id="db-table-name" placeholder="Enter a table name.">
        </div>
        <div id="upload-button-container" class="col-xs-5 qq-upload-button-selector">
          <button type="button" class="btn btn-primary">
            <span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
            Upload CSV
          </button>
        </div>
      </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
      <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
        <li>
          <div class="qq-progress-bar-container-selector">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
          </div>
          <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
          <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
          <span class="qq-upload-file-selector qq-upload-file"></span>
          <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
          <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
          <!--span class="qq-upload-size-selector qq-upload-size"></span>
          <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
          <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
          <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Delete</button-->
          <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
        </li>
      </ul>

      <dialog class="qq-alert-dialog-selector">
        <div class="qq-dialog-message-selector"></div>
        <div class="qq-dialog-buttons">
          <button type="button" class="qq-cancel-button-selector">Close</button>
        </div>
      </dialog>

      <dialog class="qq-confirm-dialog-selector">
        <div class="qq-dialog-message-selector"></div>
        <div class="qq-dialog-buttons">
          <button type="button" class="qq-cancel-button-selector">No</button>
          <button type="button" class="qq-ok-button-selector">Yes</button>
        </div>
      </dialog>

      <dialog class="qq-prompt-dialog-selector">
        <div class="qq-dialog-message-selector"></div>
        <input type="text">
        <div class="qq-dialog-buttons">
          <button type="button" class="qq-cancel-button-selector">Cancel</button>
          <button type="button" class="qq-ok-button-selector">Ok</button>
        </div>
      </dialog>
    </div>
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>--}}
  <script>
    //window.onload = function() {
    $( document ).ready(function() {
      document.getElementById("upload-button-container")
          .addEventListener("click", function (event) {
            var tableName = document.getElementById('db-table-name').value.trim();
            if (!tableName) {
              event.preventDefault();
              alert('Please enter a table name.')
            }
            else {
              uploader.setParams({table: tableName});
            }
          }, true);
    });
    var uploader = new qq.FineUploader({
      debug: true,
      element: document.getElementById('fine-uploader'),
      request: {
        endpoint: '/ricardo/app.php/table'
      },
      retry: {
        enableAuto: false
      },
      validation: {
        allowedExtensions: ['csv']
      },
      callbacks: {
//        onError: function(id, name, errorReason, xhrOrXdr) {
//          alert(qq.format("Error on file number {} - {}.  Reason: {}", id, name, errorReason));
//        },
          onComplete: function(id, name, responseJson, xhr) {
            //alert('complete ' + id + ' ' +name);
            $('#fine-uploader .qq-file-id-' + id).delay(5000).fadeOut('slow');
          }
      },
      failedUploadTextDisplay: {
        mode: 'custom'
      }
    });
  </script>
</div>
</body>

</html>