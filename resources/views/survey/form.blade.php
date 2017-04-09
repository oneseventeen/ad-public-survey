 <!DOCTYPE html>
 <html lang="en">

<head>
     <meta charset="UTF-8">
     <title>{{$survey->name}}</title>
     <meta name="description" content="DESCRIPTION">
    <link rel="stylesheet" href="PATH">

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
     <!--[if lt IE 9]>
       <script src = "http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
     <![endif]-->
 </head>

 <body>
  <div class='jumbotron'>
    <div class='container'>
      <h1>{{$survey->name}}</h1>
      <p>{{$survey->description or ''}}</p>
    </div>
  </div>
  <div class='container'>
    <div class='col-md-6 col-md-offset-3'>
      <form role="form" method="POST" action="/survey/submit/{{$survey->id}}">
        <input type='hidden' name='survey_id' value="{{$survey->id}}" />
        <input type='hidden' name='return_url' value="{{$survey->return_url or 'http://easterabq.org'}}" />
          @foreach($survey->questions as $q)
          <div class='form-group'>
            <label for="q[{{$q->id}}]" class="control-label">{{$q->label}}</label>
              @if($q->question_type == 'select')
                <select name='q-{{$q->id}}' class='form-control input-lg'>
                  <option value="-">Please Choose</option>
                  @foreach(explode('|', $q->options) as $option)
                  <option value='{{$option}}'>{{$option}}</option>
                  @endforeach
                </select>
              @else
                <input type="text" name="q-{{$q->id}}" class="form-control">
              @endif

              @if(strlen($q->description)>2)
              <span class="help-block">{{$q->description}}</span>
              @endif
          </div>
          @endforeach

          <button type="submit" class="btn btn-primary">
              Submit
          </button>
      </form>
    </div>
  </div>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </body>

 </html>
