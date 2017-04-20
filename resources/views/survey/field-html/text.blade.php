&lt;label for=&quot;q[{{$q->id}}]&quot; class=&quot;control-label&quot;&gt;{{$q->label}}
  @if($q->required)
  &lt;span class=&quot;text-danger&quot;&gt;* Required&lt;/span&gt;
  @endif
&lt;/label&gt;

&lt;input type=&quot;{{stripos($q->label, 'email') !== false ? 'email':'text'}}&quot; name=&quot;q-{{$q->id}}&quot; class=&quot;form-control&quot; value=&quot;{{old("q-" . $q->id)}}&quot; &gt;
