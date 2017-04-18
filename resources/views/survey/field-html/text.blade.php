&lt;input type=&quot;{{stripos($q->label, 'email') !== false ? 'email':'text'}}&quot; name=&quot;q-{{$q->id}}&quot; class=&quot;form-control&quot; value=&quot;{{old("q-" . $q->id)}}&quot; &gt;
