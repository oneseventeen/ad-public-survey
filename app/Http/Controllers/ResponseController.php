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
     * Export responses to a survey as raw CSV
     * @param  Survey $survey Survey object
     * @return CSV
     */
    public function exportCsv(Survey $survey)
    {
      $questions = array();
      $data = array();

      //establish the first row:
      $data[1]['Status'] = 'Status';
      foreach($survey->questions as $q) {
        $questions[$q->id] = $q->label;
        $data[1][$q->id] = $q->label;
      }
      $data[1]['Date'] = 'Date';

      //loop through the rest!
      foreach($survey->responses as $r) {
        $data[$r->id]['Status'] = ($r->processed == 1) ? 'Processed' : 'Not Processed';
        foreach($questions as $qid => $qlabel) {
          $data[$r->id][$qid] = @$r->answers()->where('question_id', $qid)->first()->value;
        }
        $data[$r->id]['Date'] = $r->updated_at;
      }

      // output headers so that the file is downloaded rather than displayed
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=survey ' . $survey->id . '-' . date('Y-m-d') . '.csv');

      // create a file pointer connected to the output stream
      $output = fopen('php://output', 'w');

      foreach($data as $row) {
        fputcsv($output, $row);
      }
      die();

    }

    /**
     * Export responses to a survey as an Excel file
     * @param  Survey $survey Survey object
     * @return Excel
     */
    public function export(Survey $survey)
    {
        $questions = array();
        $data = array();
        $data[1]['Status'] = 'Status';
        $multiple_choice = array();
        foreach($survey->questions as $q) {
          $questions[$q->id] = $q->label;
          //if(strpos($q->options, '|') !== false) {
          if($q->question_type == 'checkbox-list') {
            $tmp_counter = 0;
            foreach(explode('|', $q->options) as $opt) {
              $data[1][$q->id . ":" . $tmp_counter] = $opt;
              $multiple_choice[$q->id][$tmp_counter] = $opt;
              $tmp_counter++;
            }
          } else {
            $data[1][$q->id] = $q->label;
          }
        }
        $data[1]['date'] = 'Date';
        //echo('"' . implode('","', $questions) . '","Date"' . "\n");
        foreach($survey->responses as $r) {
          $data[$r->id]['Status'] = ($r->processed == 1) ? 'Processed' : 'Not Processed';
          foreach($questions as $qid => $qlabel) {
            $tmp_answer = @$r->answers()->where('question_id', $qid)->first()->value;
            if(!$tmp_answer) {
              $tmp_answer = '';
            }
            if(isset($multiple_choice[$qid])) {
              foreach($multiple_choice[$qid] as $counter => $opt) {
                if(stripos($tmp_answer, $opt) !== false) {
                  $data[$r->id][$qid . ":" . $counter] = "x";
                } else {
                  $data[$r->id][$qid . ":" . $counter] = "";
                }
              }
            } else {
              $data[$r->id][$qid] = @$r->answers()->where('question_id', $qid)->first()->value;
            }
          }
          //echo('"' . implode('","', $data[$r->id]) . '","' . $r->updated_at . '"' . "\n");
          $data[$r->id]['date'] = $r->updated_at;
        }
        // die();
        $location = 0;
        $safe_colors = ['#0099cc', '#00ffcc', '#3399cc', '#9999cc', '#ccccff'];
        $merge_start = array();
        $merge_end = array();
        $cell_colors = array();
        if(count($multiple_choice) > 0) {
          foreach($data[1] as $k => $value) {
            if(strpos($k, ":")) { //must be a multiple choice response:
              //grab the question ID:
              $tmp_id = substr($k, 0, strpos($k, ":"));
              $data[0][$k] = $questions[$tmp_id];
              if(!isset($merge_start[$tmp_id])) {
                $merge_start[$tmp_id] = $location;
                if(count($safe_colors) > 0) {
                  $cell_colors[$tmp_id] = array_pop($safe_colors);
                } else {
                  $cell_colors[$tmp_id] = '#eeeeee';
                }
              }
              $merge_end[$tmp_id] = $location;
            } else {
              $data[0][$k] = "";
            }
            $location++;
          }
        }
        ksort($data);

        \Excel::create('Survey ' . $survey->id . ' Results', function($excel) use($data, $survey, $multiple_choice, $merge_start, $merge_end, $cell_colors) {
          $excel->setTitle('Survey ' . $survey->id . ' Results');
          $excel->sheet('Results', function($sheet) use($data, $multiple_choice, $merge_start, $merge_end, $cell_colors) {
            $sheet->fromArray($data, null, 'A1', false, false);
            $last_letter = chr(65+count($data[1]));
            $sheet->getStyle('A1:' . $last_letter . '1')->getFont()->setBold(true);
            if(count($multiple_choice) > 0) {
              foreach($merge_start as $tmp_id => $location) {
                $start = chr(65 + $location) . "1";
                $end = chr(65 + $merge_end[$tmp_id]) . "1";
                $sheet->mergeCells($start . ":" . $end);
                $sheet->cell($start, function($cell) use($cell_colors, $tmp_id) {
                  $cell->setAlignment('center');
                  $cell->setBackground($cell_colors[$tmp_id]);
                });
                $sheet->cells(chr(65+$location) . '2:' . chr(65+$merge_end[$tmp_id]) . '2', function($cells) use($cell_colors, $tmp_id) {
                  $cells->setBackground($cell_colors[$tmp_id]);
                });
              }
              $sheet->getStyle('A2:' . $last_letter . '2')->getFont()->setBold(true);
            }
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
