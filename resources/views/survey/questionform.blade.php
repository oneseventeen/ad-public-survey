

            <div class='panel panel-info' id="new-question-form">
              <div class='panel-heading'><h3 class='panel-title'>New Question</h3></div>
              <div class='panel-body'>
                <div class='form-group'>
                  <label for="label">Label</label>
                  <input type="text" class="form-control" name="label"
                    id="label" value="{{old('label')}}">
                </div>
                <div class='form-group'>
                  <label for="type">Type</label>
                  <select name="type" class='form-control' id="type">
                    <option {{ (old("type") == "text" ? "selected":"") }}>text</option>
                    <option {{ (old("type") == "textarea" ? "selected":"") }}>textarea</option>
                    <option {{ (old("type") == "select" ? "selected":"") }}>select</option>
                  </select>
                </div>
                <div class="form-group" id="option-area">
                    <label for="options">Options for select-type</label>
                    <textarea class='form-control' name='options' id='options' rows='2'>{{old('options')}}</textarea>
                    <span id="helpBlock" class="help-block">Please enter as
                      many options as you'd like if you are making a select type
                      question.  Separate options with a pipe: | (otherwise, leave blank)</span>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value='1' name="required"> Required?
                  </label>
                </div>
              </div>
            </div>

            <script>
              window.onload =function() {
                if($('#type option:selected').text() == "select") {
                  $('#option-area').show();
                } else {
                  $('#option-area').hide();
                  $('#options').val("");
                }

               $('#type').change(function() {
                 if($('#type option:selected').text() == "select") {
                   $('#option-area').show();
                 } else {
                   $('#option-area').hide();
                   $('#options').val("");
                 }
               });
              }
            </script>
