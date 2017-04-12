<input type="{{stripos($q->label, 'email') !== false ? 'email':'text'}}"
  name="q-{{$q->id}}"
  class="form-control"
  value="{{old("q-" . $q->id)}}"
  >
