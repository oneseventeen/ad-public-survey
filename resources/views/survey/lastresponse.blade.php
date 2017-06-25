@extends('layouts.app')

@section('content')
<div class='container'>
  <div class='panel panel-default'>
    <div class='panel-heading'>
      <h1 class='panel-title'>No More Responses</h1>
    </div>
    <div class='panel-body'>
      <a href='/response/{{$survey->id}}'>Return to Response List</a>
      <p>There are no more unprocessed responses after the previous one.  Please
        <a href='/response/{{$survey->id}}'>Return to the response list</a>.</p>
    </div>
  </div>
</div>
@endsection
