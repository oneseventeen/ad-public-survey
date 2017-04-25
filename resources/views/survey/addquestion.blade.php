@extends('layouts.app')

@section('content')


<div class='container'>
  <div class='row'>
    <div class='md-col-8 md-offset-2'>
      <div class='panel panel-default'>
        <div class='panel-heading'><h3 class='panel-title'>Add Question to Survey</h3></div>
        <div class='panel-body'>
          <h3>{{$survey->name}}</h3>

          <form class='form' method="POST" action="/addquestion/{{$survey->id}}">

            @include('survey.questionform')

            <div class="form-group">
              <button type="submit" class="btn btn-primary">Submit and add another question</button>
              <a href='/list'>Cancel</a>
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
