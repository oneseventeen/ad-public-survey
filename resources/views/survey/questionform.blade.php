

            <div class='panel panel-info' id="new-question-form">
              <div class='panel-heading'><h3 class='panel-title'>New Question</h3></div>
              <div class='panel-body'>
                <div class='form-group'>
                  <label for="label">Label</label>
                  <input type="text" class="form-control" name="label"
                    id="label" value="{{old('label')}}">
                </div>
                <div class='form-group'>
                  <label for="question_type">Type</label>
                  <select name="question_type" class='form-control' id="question_type">
                    <option {{ (old("type") == "text" ? "selected":"") }}>text</option>
                    <option {{ (old("type") == "textarea" ? "selected":"") }}>textarea</option>
                    <option {{ (old("type") == "select" ? "selected":"") }}>select</option>
                    <option {{ (old("type") == "checkbox-list" ? "selected":"") }}>checkbox-list</option>
                    <option {{ (old("type") == "section" ? "selected":"") }}>section</option>
                  </select>
                </div>
                <div class="form-group" id="option-area">
                    <label for="options">Options for question types that need them</label>
                    <textarea class='form-control' name='options' id='options' rows='2'>{{old('options')}}</textarea>
                    <span id="helpBlock" class="help-block">Please enter as
                      many options as you'd like if you are making a select type
                      or checkbox-list type question.  Separate options with a pipe: | (otherwise, leave blank or for section type include section text)</span>
                </div>
                <div class="col-md-6">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" value='1' name="required"> Required?
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="css_class">CSS Class </label><input class='form-control' id='css_class' type='text' name='css_class' placeholder="col-md-6" value="{{old('css_class')}}">
                </div>
              </div>
            </div>

            <script>
              window.onload =function() {
                var optionfields = ["select", "checkbox-list", "section"];

                if(optionfields.includes($('#question_type option:selected').text())) {
                  $('#option-area').show();
                } else {
                  $('#option-area').hide();
                  $('#options').val("");
                }

               $('#question_type').change(function() {
                 if(optionfields.includes($('#question_type option:selected').text())) {
                   $('#option-area').show();
                 } else {
                   $('#option-area').hide();
                   $('#options').val("");
                 }
               });

               $('#label').focus();
              }
            </script>
