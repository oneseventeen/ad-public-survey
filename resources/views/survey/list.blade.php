@extends('layouts.app')

@section('content')
<div class='container'>
  <div class='row'>
    <div class='md-col-8 md-offset-2'>
      <div class='panel panel-default'>
        <div class='panel-heading'><h3 class='panel-title'>List of Surveys</h3></div>
        <div class='panel-body'>
          <p><a href='/new' class='btn btn-success'>New Survey</a></p>
          @if($surveys->count() > 0)
          <table class='table table-striped'>
            <thead>
              <tr>
                <th>Take Survey</th>
                <th>View Responses</th>
                <th>HTML</th>
                <th>Add Questions</th>
                <th>Edit Survey</th>
              </tr>
            </thead>
            <tbody>
              @foreach($surveys as $s)
                <tr>
                  <td><a href='/survey/{{$s->id}}'>{{$s->name}}</a></td>
                  <td><a href='/response/{{$s->id}}'>{{$s->responses->count()}} responses</a></td>
                  <td><a href='/survey/code/{{$s->id}}'>View Code</a></td>
                  <td><a href='/addquestion/{{$s->id}}'>Add Question</a></td>
                  <td><a href='/survey/edit/{{$s->id}}'>Edit Survey</a></td>
                </tr>
              @endforeach
            </tbody>
            @endif
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
