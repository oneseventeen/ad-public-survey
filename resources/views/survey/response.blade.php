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
          @foreach($data as $label => $answer)
            <tr>
              <th scope='row'>{{$label}}</th>
              <td>{{$answer}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <a href='/response/next/{{$response->id}}' class='btn btn-success'>Mark Completed and View Next</a>
    </div>
  </div>
</div>
@endsection
