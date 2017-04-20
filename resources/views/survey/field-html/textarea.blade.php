&lt;label for=&quot;q[{{$q->id}}]&quot; class=&quot;control-label&quot;&gt;{{$q->label}}
  @if($q->required)
  &lt;span class=&quot;text-danger&quot;&gt;* Required&lt;/span&gt;
  @endif
&lt;/label&gt;

&lt;textarea name=&quot;q-{{$q->id}}&quot; class=&quot;form-control&quot; rows=&quot;4&quot; &gt;{{old('q-' . $q->id)}}&lt;/textarea&gt;
