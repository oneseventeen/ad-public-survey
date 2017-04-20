

  <label for="q[{{$q->id}}]" class="control-label">{{$q->label}}
    @if($q->required)
    <span class="text-danger">* Required</span>
    @endif
  </label>

  <select name='q-{{$q->id}}' class='form-control input-lg'>
    <option value="">Please Choose</option>
    @foreach(explode('|', $q->options) as $option)
    <option value='{{$option}}' {{old('q-' . $q->id) == $option?'selected':''}}>{{$option}}</option>
    @endforeach
  </select>
