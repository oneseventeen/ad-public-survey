<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * Attributes that are mass assignable
     * @var array Mass assignable fields
     */
    protected $fillable = ['survey_response_id', 'question_id', 'value'];

    /**
     * Get the Survey Response associated with this answer
     */
    public function SurveyResponse()
    {
      return $this->belongsTo('App\SurveyResponse');
    }

    /**
     * Get the question associated with this answer
     */
    public function question()
    {
      return $this->belongsTo('App\Question');
    }
}
