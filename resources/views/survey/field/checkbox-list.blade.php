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
