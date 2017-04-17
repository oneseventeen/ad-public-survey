<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\SurveyResponse;
use \App\Survey;

class ResponseController extends Controller
{
    /**
     * Show responses to a survey by populating an array and displaying a view
     * @param  Survey $survey Survey object
     * @return view
     */
    public function show(Survey $survey)
    {
      $questions = array();
      $data = array();
      foreach($survey->questions as $q) {
        $questions[$q->id] = $q->label;
      }
      foreach($survey->responses as $r) {
        foreach($questions as $qid => $qlabel) {
          $data[$r->id][$qid] = @$r->answers()->where('question_id', $qid)->first()->value;
        }
        $data[$r->id]['date'] = $r->updated_at;
      }
      return view('survey.results', ['data'=>$data, 'questions'=>$questions, 'survey'=>$survey]);
      //return $survey->responses()->first()->answers()->first();
    }

    /**
     * Export responses to a survey by populating an array and showing CSV
     * @param  Survey $survey Survey object
     * @return CSV
     */
    public function export(Survey $survey)
    {
        $questions = array();
        $data = array();
        foreach($survey->questions as $q) {
          $questions[$q->id] = $q->label;
          $data[0][$q->id] = $q->label;
        }
        $data[0]['date'] = 'Date';
        //echo('"' . implode('","', $questions) . '","Date"' . "\n");
        foreach($survey->responses as $r) {
          foreach($questions as $qid => $qlabel) {
            $data[$r->id][$qid] = @$r->answers()->where('question_id', $qid)->first()->value;
          }
          //echo('"' . implode('","', $data[$r->id]) . '","' . $r->updated_at . '"' . "\n");
          $data[$r->id]['date'] = $r->updated_at;
        }
        // die();

        \Excel::create('Survey ' . $survey->id . ' Results', function($excel) use($data, $survey) {
          $excel->setTitle('Survey ' . $survey->id . ' Results');
          $excel->sheet('Results', function($sheet) use($data) {
            $sheet->fromArray($data, null, 'A1', false, false);
            $last_letter = chr(65+count($data[0]));
            $sheet->getStyle('A1:' . $last_letter . '1')->getFont()->setBold(true);
          });
        })->download('xlsx');
    }

    /**
     * flag a response as processed
     * @param  SurveyResponse $survey_response [description]
     * @return [type]                          [description]
     */
    public function process(SurveyResponse $survey_response)
    {
      $survey_response->markAsProcessed();
      return back()->with('success', ['marked response as processed']);
    }
}
