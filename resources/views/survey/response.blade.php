@extends('layouts.app')

@section('content')
<div class='container'>
  <div class='panel panel-default'>
    <div class='panel-heading'>
      <h1 class='panel-title'>Response will go here</h1>
    </div>
    <div class='panel-body'>
      <a href='/response/{{$response->survey->id}}'>Return to Response List</a>
      <p><strong>Response Created:</strong> {{$response->created_at}}<p>
      <table class='table table-bordered table-striped'>
        <colgroup>
          <col class="col-xs-2">
          <col class="col-xs-10">
        </colgroup>
        <thead>
          <tr class='bg-primary'>
            <th>Question</th>
            <th>Response</th>
          </tr>
        </thead>
        <tbody>
          @foreach($response->survey->questions as $question)
            @if($question->question_type != 'section')
            <tr>
              <th scope='row'>{{$question->label}}</th>
              <td>{{$response->answers()->where('question_id', $question->id)->value('value')}}</td>
            </tr>
            @endif
          @endforeach
        </tbody>
      </table>
      <a href='/response/next/{{$response->id}}' class='btn btn-success'>Mark Completed and View Next</a>
    </div>
  </div>
</div>
@endsection
