
  <label for="q[{{$q->id}}]" class="control-label">{{$q->label}}
    @if($q->required)
    <span class="text-danger">* Required</span>
    @endif
  </label>

<input type="{{stripos($q->label, 'email') !== false ? 'email':'text'}}"
  name="q-{{$q->id}}"
  class="form-control"
  value="{{old("q-" . $q->id)}}"
  >
