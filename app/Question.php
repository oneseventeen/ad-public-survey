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
     * Get teh survey that owns the question
     */
    public function survey()
    {
      return $this->belongsTo('App\Survey');
    }
}
