@extends('layouts.app')

@section('content')
  <div class='container'>
    <div class='col-md-10 col-md-offset-1 survey-questions'>
      <div class="panel panel-default">
        <div class='panel-heading'>
          <h1 class='panel-title'>Embeddable HTML Form</h1>
        </div>
        <div class='panel-body'>
          <p><a href='/list' class='btn'>Return to List</a></p>
      <pre>
&lt;form role=&quot;form&quot; method=&quot;POST&quot; action=&quot;{{Config::get('app.url')}}/survey/submit/{{$survey->id}}&quot;&gt;
  &lt;input type=&quot;hidden&quot; name=&quot;survey_id&quot; value=&quot;{{$survey->id}}&quot; /&gt;
  @if($survey->return_url)
    &lt;input type=&quot;hidden&quot; name=&quot;return_url&quot; value=&quot;{{$survey->return_url}}&quot; /&gt;
  @endif
    @foreach($survey->questions as $q)

    &lt;div class=&quot;form-group{{ $errors->has('$q-' . $q->id) ? ' has-error' : '' }}&quot;&gt;
      &lt;label for=&quot;q-{{$q->id}}&quot; class=&quot;control-label&quot;&gt;{{$q->label}}@if($q->required) &lt;span class=&quot;text-danger&quot;&gt;* Required&lt;/span&gt;@endif&lt;/label&gt;
      @include('survey.field-html.' . $q->question_type)
@if(strlen($q->description)>2)
        &lt;span class=&quot;help-block&quot;&gt;{{$q->description}}&lt;/span&gt;
@endif
    &lt;/div&gt;
    @endforeach
&lt;div class=&quot;form-group&quot;&gt;
      &lt;button type=&quot;submit&quot; class=&quot;btn btn-primary&quot;&gt;Submit&lt;/button&gt;
    &lt;/div&gt;
&lt;/form&gt;
    </pre>
    </div>
    </div>
    </div>
  </div>
@endsection
