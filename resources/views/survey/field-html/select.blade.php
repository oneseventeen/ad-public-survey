
  &lt;select name=&quot;q-{{$q->id}}&quot; class=&quot;form-control input-lg&quot;&gt;
        &lt;option value=&quot;&quot;&gt;Please Choose&lt;/option&gt;
    @foreach(explode('|', $q->options) as $option)
    &lt;option value=&quot;{{$option}}&quot; {{old('q-' . $q->id) == $option?'selected':''}}&gt;{{$option}}&lt;/option&gt;
    @endforeach
  &lt;/select&gt;
