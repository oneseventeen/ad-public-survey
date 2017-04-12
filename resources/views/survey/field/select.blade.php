
  <select name='q-{{$q->id}}' class='form-control input-lg'>
    <option value="">Please Choose</option>
    @foreach(explode('|', $q->options) as $option)
    <option value='{{$option}}' {{old('q-' . $q->id) == $option?'selected':''}}>{{$option}}</option>
    @endforeach
  </select>
