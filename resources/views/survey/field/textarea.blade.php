
  <label for="q[{{$q->id}}]" class="control-label">{{$q->label}}
    @if($q->required)
    <span class="text-danger">* Required</span>
    @endif
  </label>

<textarea name="q-{{$q->id}}" class="form-control" rows='4'
  >{{old('q-' . $q->id)}}</textarea>
