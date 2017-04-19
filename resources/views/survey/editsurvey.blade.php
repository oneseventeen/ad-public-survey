@extends('layouts.app')

@section('content')
<div class='container'>
  <div class='row'>
    <div class='md-col-8 md-offset-2'>
      <div class='panel panel-default'>
        <div class='panel-heading'><h3 class='panel-title'>Create New Survey</h3></div>
        <div class='panel-body'>
          <form class='form' method="POST" action="/survey/edit/{{$survey->id}}">
{{ csrf_field() }}
            <div class="form-group">
              <label for="name">Survey Name
                <span class='text-danger'>* Required</span>
              </label>
              <div class="required-field-block">
                  <input type="text" class="form-control" name="name" id="name"
                  value="{{$survey->name}}" placeholder="Name of Survey">
              </div>
            </div>

            <div class="form-group">
              <label for="description">Description</label>
                <textarea class='form-control' name="description"
                  id="description"  placeholder="Description of Survey"
                  rows='3'>{{ $survey->description }}</textarea>
            </div>


            <div class="form-group">
              <label for="css">CSS</label>
                <textarea class='form-control' name="css" id="css"
                placeholder="CSS for Survey page"
                rows='3'>{{ $survey->css }}</textarea>
                <span id="helpBlock" class="help-block">CSS for the form page,
                  feel free to include background images, etc. This will be
                  added inside &lt;style&gt; tags, so no need to include those.
                </span>
            </div>

            <div class="form-group">
              <label for="return_url">Return URL</label>
              <div class="field-block">
                  <input type="text" class="form-control" name="return_url"
                  id="return_url" value="{{$survey->return_url}}"
                  placeholder="http://google.com">
                <span id="helpBlock" class="help-block">URL (including http://
                  or https://) to redirect users to after they complete the
                  survey.  If left blank, they will get a white page with the
                  words Thank You.
                </span>
              </div>
            </div>


            <div class="form-group">
              <label for="thank_you_message">Thank You Message</label>
                <textarea class='form-control' name="thank_you_message"
                  id="thank_you_message"
                  placeholder="Your custom Thank You Message"
                  rows='3'>{{ $survey->thank_you_message }}</textarea>
                <span id="helpBlock" class="help-block">Thank you message text to appear below the title 'Thank You'.  Newlines will be converted to paragraphs. No HTML.
                </span>
            </div>
<!-- this is where the question form was -->
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Save Changes</button> <a href='/list' class='btn'>Cancel</a>
          </div>
          @include('layouts.errors')
          </form>

          @if($survey->questions()->count() > 0)
            <div class='panel panel-warning'>
              <div class='panel-heading'><h3 class='panel-title'>Existing Questions:</h3></div>
              <ul>
                @foreach($survey->questions as $q)
                  <li>{{$q->label}} ({{$q->question_type}})
                    @if($q->required)
                    [Required]
                    @endif
                  @if($q->question_type == 'select' || $q->question_type == 'checkbox-list')
                    <ul>
                      @foreach(explode('|', $q->options) as $o)
                        <li>{{$o}}</li>
                      @endforeach
                    </ul>
                  @endif</li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('foot')
  @parent
  <script>

  </script>
@stop
