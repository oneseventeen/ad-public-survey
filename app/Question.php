<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * Attributes that are mass assignable
     * @var array Mass assignable fields
     */
    protected $fillable = ['survey_id', 'question_type', 'label', 'description', 'options', 'required', 'css_class'];

    /**
     * Get the survey that owns the question
     */
    public function survey()
    {
      return $this->belongsTo('App\Survey');
    }

    /**
     * Move question to a particular spot
     */
    public static function moveQuestion($id, $position)
    {
      $question = \App\Question::find($id);
      $survey = $question->survey;
      //make sure the survey is already numbered:
      $survey->number_questions();

      //now get the current position:
      $new_question = \App\Question::find($id);
      //let's set this to a different variable since we'll be changing it later
      $current_position = $new_question->order;

      //if it is already the position we want, then return true:
      if($current_position == $position) {
        return true;
      }

      //otherwise, let's change some order numbers!

      //first, let's test for moving back (which should only increment others)
      if($position < $current_position) {
        foreach($survey->questions as $q) {
          if($q->order >= $position
            && $q->id != $id //don't change the current question yet
            && $q->order < $current_position) {
              //increment the order of the current question in the loop:
              $q->order++;
              $q->save();
            }
        }
      // otherwise, let's loop through and move forward, decrementing others:
      } else {
        foreach($survey->questions as $q) {
          if($q->order <= $position
            && $q->id != $id
            && $q->order > $current_position) {
              $q->order--;
              $q->save();
            }
        }
      }

      //now set the new position of the question in question :)
      $new_question->order = $position;
      $new_question->save();
      // echo("I just tried changing question " . $new_question->id . " to " . $position . " which resulted in: " . $new_question->order);
      return true;

    }

}
