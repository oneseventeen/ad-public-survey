<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{

  /**
   * Attributes that are mass assignable
   * @var array Mass assignable fields
   */
  protected $fillable = ['survey_id', 'ip'];

  /**
   * Get the survey that owns the response
   */
  public function survey()
  {
    return $this->belongsTo('App\Survey');
  }

  /**
   * Get the answers that belong to this response
   */
  public function answers()
  {
    return $this->hasMany('App\Answer');
  }

}
