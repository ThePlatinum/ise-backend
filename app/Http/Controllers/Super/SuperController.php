<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class SuperController extends Controller
{
    //
    public function migrate() {
      Artisan::call('migrate:refresh --seed');
      return response(['DB refresh and seed done'], 200);
    }
}
