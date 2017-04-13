 <!DOCTYPE html>
 <html lang="en">

<head>
     <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>{{$survey->name}}</title>
     <meta name="description" content="DESCRIPTION">
    <link rel="stylesheet" href="PATH">

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
     <!--[if lt IE 9]>
       <script src = "http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
     <![endif]-->

     <!--
     <?php var_dump($errors);
     echo("old input\n\n");
var_dump(Session::getOldInput());
     ?>
     -->
     <style>
       .input-group-btn:not(:first-child):not(:last-child) > .btn {
          border-radius: 0;
          height: 100%;
        }
        {!! $survey->css !!}
     </style>
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

      @include('layouts.errors')
      <form role="form" method="POST" action="/survey/submit/{{$survey->id}}">
        <input type='hidden' name='survey_id' value="{{$survey->id}}" />
        @if($survey->return_url)
          <input type='hidden' name='return_url' value="{{$survey->return_url}}" />
        @endif
          @foreach($survey->questions as $q)

          <div class='form-group{{ $errors->has('q-' . $q->id) ? ' has-error' : '' }}'>
            <label for="q[{{$q->id}}]" class="control-label">{{$q->label}}
              @if($q->required)
              <span class='text-danger'>* Required</span>
              @endif
            </label>
              @include('survey.field.' . $q->question_type)

              @if(strlen($q->description)>2)
              <span class="help-block">{{$q->description}}</span>
              @endif
          </div>
          @endforeach
          <div class='form-group'>
            <button type="submit" class="btn btn-primary">
                Submit
            </button>
          </div>
      </form>
    </div>
  </div>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </body>

 </html>
