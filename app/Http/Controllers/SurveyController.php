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
          echo("trying to add answer");
          $answerArray[$question->id] = array(
            'value'=> $request->input('q-' . $question->id),
            'question_id'=>$question->id
          );
        } else {
          echo("could not find q-" . $question->id );
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
        echo("boo " . $errorcount);
      }
      echo("<pre>\n");
      var_dump($request->all());
      die("</pre>\n");

    }
}
