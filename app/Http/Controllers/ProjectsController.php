<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    //
    public function categories(){
      $allcat = Categories::get();
      return response($allcat, 200);
    }
}
