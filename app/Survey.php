<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    /**
     * Attributes that are mass assignable
     * @var array Mass assignable fields
     */
    protected $fillable = ['name', 'description', 'css', 'return_url', 'thank_you_message', 'slug'];

    /**
     * Get the questions associated with this survey
     */
    public function questions()
    {
      return $this->hasMany('App\Question')->orderBy('order');
    }

    public static function named($slug)
    {
      return Survey::where('slug', $slug)->first();
    }

    /**
     * Get the responses associated with this survey
     */
    public function responses()
    {
      return $this->hasMany('App\SurveyResponse')->orderBy('processed');
    }


    /**
     * Number all questions in a survey
     */
    public function number_questions()
    {
      //First check to see if there are even any questions:
      if($this->questions()->count() < 1) {
        return true;
      }

      //Now, check to see if the questions are already numbered:
      if($this->questions()->first()->order !== null) {
        return true;
      }

      //Now, loop through and order the questions based on default ordering:
      $current_number = 0;
      foreach($this->questions as $question) {
        $current_number++;
        $question->order = $current_number;
        $question->save();
      }

      return true;
    }
}
