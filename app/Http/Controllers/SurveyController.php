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

      $survey = new Survey();
      $survey->name = $request->input('name');
      if($request->has('description')) {
        $survey->description = $request->input('description');
      }
      if($request->has('return_url')) {
        $survey->return_url = $request->input('return_url');
      }
      $survey->save();
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
      $validation_array = array('label'=>'required|max:255');
      if($request->has('type') && $request->input('type') == 'select') {
        $validation_array['options'] = 'required';
      }
      $this->validate($request, $validation_array);
      $data = array();
      $data['label'] = $request->input('label');
      $data['question_type'] = $request->input('type');
      if($request->has('options')) {
        $data['options'] = $request->input('options');
      }
      if($request->has('required')) {
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
      $errorcount = 0;
      $answerArray = array();

      //loop through questions and check for answers
      foreach($survey->questions as $question) {
        if($question->required
            && !$request->has('q-' . $question->id) ) {
          $errorcount++;
        }
        if($request->has('q-' . $question->id) && strlen(trim($request->input('q-' . $question->id))) > 0) {
          // echo("trying to add answer");
          $answerArray[$question->id] = array(
            'value'=> $request->input('q-' . $question->id),
            'question_id'=>$question->id
          );
        } else {
          // echo("could not find q-" . $question->id );
        }
      }

      //if no errors, submit form!
      if($errorcount == 0 && count($answerArray) > 0) {
        $sr = new \App\SurveyResponse(['survey_id'=>$id, 'ip'=>$_SERVER['REMOTE_ADDR']]);
        $sr->save();
        foreach($answerArray as $qid => $ans) {
          // print_r($ans);
          $sr->answers()->create($ans);
        }
      } else {
        // echo("boo " . $errorcount);
      }
      // echo("<pre>\n");
      // var_dump($request->all());
      // die("</pre>\n");


        if($request->has('return_url')
            && strlen($request->input('return_url'))>5) {
           return redirect()->away($request->input('return_url'));
           //->header('Location', $request->input('return_url'));
        } else {
          return redirect('thanks');
        }
    }
}
