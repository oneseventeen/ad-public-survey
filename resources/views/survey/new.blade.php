@extends('layouts.app')

@section('content')


<div class='container'>
  <div class='row'>
    <div class='md-col-8 md-offset-2'>
      <div class='panel panel-default'>
        <div class='panel-heading'><h3 class='panel-title'>Create New Survey</h3></div>
        <div class='panel-body'>
          <form class='form' method="POST" action="/survey/create">
{{ csrf_field() }}
            <div class="form-group">
              <label for="name">Survey Name</label>
              <div class="required-field-block">
                <div class="input-group">
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name of Survey">
                  <span class="input-group-addon">Required</span>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="description">Description [optional]</label>
              <div class="input-group">
                <textarea class='form-control' name="description" id="description"  placeholder="Description of Survey" rows='3'>{{ old('description') }}</textarea>
                <span class="input-group-addon">Optional</span>
              </div>
            </div>

            <div class="form-group">
              <label for="return_url">Return URL</label>
              <div class="required-field-block">
                <div class="input-group">
                  <input type="text" class="form-control" name="return_url" id="return_url" placeholder="http://google.com">
                  <span class="input-group-addon">Optional</span>
                </div>
                <span id="helpBlock" class="help-block">URL (including http://
                  or https://) to redirect users to after they complete the
                  survey.  If left blank, they will get a white page with the
                  words Thank You.
                </span>
              </div>
            </div>
<!-- this is where the question form was -->
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit and add questions</button> <a href='/list' class='btn'>Cancel</a>
          </div>
          @include('layouts.errors')
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
