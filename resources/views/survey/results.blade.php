@extends('layouts.app')

@section('content')

<div class='container'>
  <div class='row'>
    <div class='col-mid-8 col-offset-2'>
      <div class='panel panel-default'>
        <div class='panel-heading'>
          <h1 class='panel-title'>{{$survey->name}}</h1>
        </div>
        <div class='panel-body'>
          @if(session('success'))
          <div class='alert alert-success'>
            <ul>
                @foreach(session('success') as $success_message)
                  <li>{{$success_message}}</li>
                @endforeach
            </ul>
          </div>
          @endif
          <p><a class='btn btn-success' href="/survey/{{$survey->id}}">Take Survey</a>
            @if($survey->responses()->count()>0)
            <a class='btn btn-primary' href="/response/export/{{$survey->id}}">Download Results (xlsx)</a>
            @endif
            <a href='/list' class='btn'>Return to List</a></p>
            <div class='table-responsive'>
          <table class="table table-striped">
            <thead>
              <th>Status</th>
              @foreach($questions as $q)
              <th title="{{$q}}">{{str_limit($q, 15)}}</th>
              @endforeach
              <th>Date</th>
            </thead>
            <tbody>
              @foreach($survey->responses as $response)
              <tr class="{{ ($response->processed)?'row-processed':'' }}">
                <td>@if($response->processed)
                    processed
                  @else
                    <a href='/response/process/{{$response->id}}' class='btn btn-primary'>Mark Complete</a>
                  @endif
                </td>
                @foreach($questions as $qid=>$q)
                <td>{{ $data[$response->id][$qid] or "-" }}</td>
                @endforeach
                <td title='{{$response->created_at}}'>{{ $response->created_at->diffForHumans() }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
