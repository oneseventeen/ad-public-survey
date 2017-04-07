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

    public function submit()
    {
      die('post!');
    }
}
