  @foreach(explode('|', $q->options) as $option)
    &lt;div class='checkbox'&gt;
        &lt;label&gt;
          &lt;input type=&quot;checkbox&quot; name=&quot;q-{{$q->id}}[]&quot; value=&quot;{{$option}}&quot;&gt;{{$option}}
        &lt;/label&gt;
      &lt;/div&gt;
  @endforeach
