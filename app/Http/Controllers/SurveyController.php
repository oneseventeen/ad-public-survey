<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Show the selected survey
     *
     * @param int $id
     * @return Response
     */

    public function show($id)
    {
      return view('survey.form', ['survey'=> Survey::findOrFail($id)]);
    }

    /**
     * Save a new survey
     * @param  Request $request Form request data
     * @return redirect to add question form
     */
    public function create(Request $request)
    {

      $this->validate($request, [
          'name' => 'required|max:255'
      ]);

      $survey_details = $request->only([
        'name', 'description', 'return_url', 'css', 'thank_you_message', 'slug'
      ]);

      if(isset($survey_details['slug'])) {
        $survey_details['slug'] = str_replace(' ','_', $survey_details['slug']);
      }

      //ok, we're valid, now to save form data as a new survey:
      $survey = Survey::create(
        $survey_details
      );
      /*
      $survey = new Survey();
      $survey->name = $request->input('name');
      if($request->has('description')) {
        $survey->description = $request->input('description');
      }
      if($request->has('return_url')) {
        $survey->return_url = $request->input('return_url');
      }
      if($request->has('css')) {
        $survey->css = $request->input('css');
      }

      $survey->save();
      */
      return redirect('/addquestion/' . $survey->id . '#new-question-form');
    }

    /**
     * Save a new question for a survey
     * @param  Request $request submitted question form
     * @param  Survey  $survey  Survey to add the question to
     * @return view
     */
    public function addquestion(Request $request, Survey $survey)
    {
      $this->validate($request, [
          'label'=>'required|max:255',
          'options'=>'required_if:type,select,checkbox-list,section'
        ]);
      $data = array();
      $data['label'] = $request->input('label');
      $data['question_type'] = $request->input('type');
      if($request->has('options')) {
        $data['options'] = $request->input('options');
      }
      if($request->has('required') && $request->input('type') != 'section') {
        $data['required'] = '1';
      }
      // return($data);
      $survey->questions()->create($data);
      return redirect('/addquestion/' . $survey->id . '#new-question-form');
    }

    /**
     * Post a response to a survey.
     *
     * @param  Request $request Form request data
     * @param  int  $id      survey to post a response to
     * @return redirect      redirects to success page or form w/errors
     */
    public function submit(Request $request, $id)
    {
      if($id != $request->input('survey_id')) {
        if($request->has('return_url')
            && strlen($request->input('return_url'))>5) {
           return response()
           ->header('Location', $request->input('return_url'));
        }
      }

      $survey = \App\Survey::find($id);
      $answerArray = array();
      $validationArray = array();
      $messageArray = array();

      //loop through questions and check for answers
      foreach($survey->questions as $question) {
        if($question->required)
        {
          $validationArray['q-' . $question->id] =  'required';
          $messageArray['q-' . $question->id . '.required'] = $question->label . ' is required';
        }
        if($request->has('q-' . $question->id)) {
          if(is_array($request->input('q-' . $question->id)) && count($request->input('q-' . $question->id))) {
            $answerArray[$question->id] = array(
              'value' => implode('|', $request->input('q-' . $question->id)),
              'question_id' => $question->id
            );
          } elseif ( strlen(trim($request->input('q-' . $question->id))) > 0) {

            $answerArray[$question->id] = array(
              'value'=> $request->input('q-' . $question->id),
              'question_id'=>$question->id
            );

          } // I guess there is an empty string
        }
      }



      $this->validate($request, $validationArray, $messageArray);

      //if no errors, submit form!
      if(count($answerArray) > 0) {
        $sr = new \App\SurveyResponse(['survey_id'=>$id, 'ip'=>$_SERVER['REMOTE_ADDR']]);
        $sr->save();
        foreach($answerArray as $qid => $ans) {
          // print_r($ans);
          $sr->answers()->create($ans);
        }
      }


        if($survey->return_url
            && strlen($survey->return_url)>5) {
           return redirect()->away($survey->return_url);
        } else {
          return redirect('thanks/' . $survey->id);
        }
    }

    /**
     * Show form to edit Survey
     * @param  Survey $survey
     * @return view
     */
    public function editSurveyForm(Survey $survey)
    {
      return view('survey.editsurvey', ['survey'=>$survey]);
    }

    public function editSurvey(Request $request, Survey $survey)
    {
      $this->validate($request, [
        'name'  =>  'required|max:255'
      ]);

      $survey->name = $request->input('name');
      $survey->description = $request->input('description');
      $survey->css = strip_tags($request->input('css'));
      $survey->return_url = $request->input('return_url');
      $survey->thank_you_message = $request->input('thank_you_message');
      $survey->slug = str_replace(' ', '_', $request->input('slug'));
      $survey->save();
      return redirect('list')->with('status',"Successfully edited Survey " . $survey->id);
    }
}
