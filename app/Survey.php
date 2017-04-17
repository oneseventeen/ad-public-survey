<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    /**
     * Attributes that are mass assignable
     * @var array Mass assignable fields
     */
    protected $fillable = ['name', 'description', 'css', 'return_url', 'thank_you_message'];

    /**
     * Get the questions associated with this survey
     */
    public function questions()
    {
      return $this->hasMany('App\Question');
    }

    /**
     * Get the responses associated with this survey
     */
    public function responses()
    {
      return $this->hasMany('App\SurveyResponse');
    }
}
