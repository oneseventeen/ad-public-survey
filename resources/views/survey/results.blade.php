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
          <p><a class='btn btn-success' href="/survey/{{$survey->id}}">Take Survey</a> <a class='btn btn-primary' href="/response/export/{{$survey->id}}">Download Results (csv)</a> <a href='/list' class='btn'>Return to List</a></p>
          <table class="table table-striped">
            <thead>
              @foreach($questions as $q)
              <th title="{{$q}}">{{str_limit($q, 15)}}</th>
              @endforeach
              <th>Date</th>
            </thead>
            <tbody>
              @foreach($data as $rid=>$response)
              <tr>
                @foreach($questions as $qid=>$q)
                <td>{{$response[$qid] or "-"}}</td>
                @endforeach
                <td>{{$data[$rid]['date']}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
