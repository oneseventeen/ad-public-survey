
  <label for="q[{{$q->id}}]" class="control-label">{{$q->label}}
    @if($q->required)
    <span class="text-danger">* Required</span>
    @endif
  </label>

  @foreach(explode('|', $q->options) as $option)
  <div class='checkbox'>
    <label>
      <input type='checkbox'
        {{(is_array(old('q-'  . $q->id))
          && in_array($option, old('q-'  . $q->id)))?'checked':''}}
        name='q-{{$q->id}}[]' value='{{$option}}'>{{$option}}
    </label>
  </div>
  @endforeach
