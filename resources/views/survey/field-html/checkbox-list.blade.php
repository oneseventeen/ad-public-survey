    &lt;label for=&quot;q[{{$q->id}}]&quot; class=&quot;control-label&quot;&gt;{{$q->label}}
      @if($q->required)
      &lt;span class=&quot;text-danger&quot;&gt;* Required&lt;/span&gt;
      @endif
    &lt;/label&gt;
  @foreach(explode('|', $q->options) as $option)
    &lt;div class='checkbox'&gt;
        &lt;label&gt;
          &lt;input type=&quot;checkbox&quot; name=&quot;q-{{$q->id}}[]&quot; value=&quot;{{$option}}&quot;&gt;{{$option}}
        &lt;/label&gt;
      &lt;/div&gt;
  @endforeach
