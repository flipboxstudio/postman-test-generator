<!DOCTYPE html>
<html>
<head>
	<title>Laravel 5.3 - Form Validation</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>AppGenerator</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/jumbotron-narrow.css') }}" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="{{ asset('js/ie-emulation-modes-warning.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
    <style>
        pre {
               background-color: ghostwhite;
               border: 1px solid silver;
               padding: 10px 20px;
               margin: 20px; 
               }
            .json-key {
               color: brown;
               }
            .json-value {
               color: navy;
               }
            .json-string {
               color: olive;
               }
    </style>
</head>
<body>

<div class="col-lg-6">
	<h2>JSON SCHEMA GENERATOR</h2>
	<form method="post" action="/" autocomplete="off">

		@if(count($errors))
			<div class="alert alert-danger">
				<strong>Whoops!</strong> There were some problems with your input.
				<br/>
				<ul>
					@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<input id="deta" type="hidden" name="_token" value="{{ csrf_token() }}">

		<div class="row">
			<div class="col-md-10">
				
					<label for="details">JSON:</label>
					<textarea name="details" id="details" class="form-control" placeholder="Enter JSON" rows="40" value="">@if(Session::has('details')){{ Session::get('details')}}@endif</textarea>
					
				
                <p><label>Response Time:</label>
                    <input type="text" name="response" class="form-control input" value="@if(Session::has('response')){{ Session::get('response')}}@endif" size="50" placeholder="response time"></p>
			</div>
		</div>

		<div class="form-group">
			<button class="btn btn-success" type="submit" name="commit" value="submit" >Submit</button>
		</div>
 
	</form>

    

</div>
    
<div class="col-lg-6">
    @if(!count($errors)  && Session::has('details') && Session::get('response'))
    <div>
    <pre>
    var error = responseCode.code === 500;
    var empty = responseCode.code === 204;

    if(error) // block below is for 500 error scenario
    {
        tests["Response Error"] = error !== true;
    }
    else if(empty) // block below is for empty scenario
    { 
        tests["Response Empty"] = empty === true;
    }
    else // block below is for return with payload
    {
        tests["Response time is less than 500ms"] = responseTime <  {{$response}};

        tests["Body matches string"] = responseBody.has("status");
        tests["Body matches string"] = responseBody.has("data");
        tests["Body matches string"] = responseBody.has("message");

        var schema = <code id=account></code>;

        var data = JSON.parse(responseBody);
        console.log(tv4.error);
        tests["Valid Data Structure"] = tv4.validate(data, schema);   

        if(data.success) // case success
        {
            tests["Status code equal 200"] = responseCode.code === 200;
        }
        else // case failed
        {
            tests["Status code is not equal to 500"] = responseCode.code !== 500;
            tests["Status code is not equal to 200"] = responseCode.code !== 200;
            tests["Error message should present"] = data.message.length > 0;
        }
    }
    
    </pre>
    </div>
    @endif
    </div>

<script type="text/javascript">
   
    if (!library)
    var library = {};

    library.json = {
       replacer: function(match, pIndent, pKey, pVal, pEnd) {
          var key = '<span class=json-key>';
          var val = '<span class=json-value>';
          var str = '<span class=json-string>';
          var r = pIndent || '';
          if (pKey)
             r = r + key + pKey.replace(/[": ]/g, '') + '</span>: ';
          if (pVal)
             r = r + (pVal[0] == '"' ? str : val) + pVal + '</span>';
          return r + (pEnd || '');
          },
       prettyPrint: function(obj) {
          var jsonLine = /^( *)("[\w]+": )?("[^"]*"|[\w.+-]*)?([,[{])?$/mg;
          return JSON.stringify(obj, null, 3)
             .replace(/&/g, '&amp;').replace(/\\"/g, '&quot;')
             .replace(/</g, '&lt;').replace(/>/g, '&gt;')
             .replace(jsonLine, library.json.replacer);
          }
       };
    var account =  <?php echo $result?>;
    $('#account').html(library.json.prettyPrint(account));
    
    

</script>
</body>
</html>