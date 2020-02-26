<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class CobaCobaController extends BaseController
{
  public function setCache(){
    Cache::put("123agung", (object)["line_id" => "123agung", "flow_name" => "Quiz", "last_topic" => "startQuiz", "next_topic" => "selectQuiz", "data" => ["name" => "aaa" , "failed" => 1] ], Carbon::now()->addMinutes(1));
    Cache::put("321agung", (object)["line_id" => "321agung", "flow_name" => "Quiz", "last_topic" => "startQuiz", "next_topic" => "selectQuiz", "data" => ["name" => "aaa" , "failed" => 1] ], Carbon::now()->addMinutes(1));
    echo "cache succes";
  }

  public function getCache()
  {
    $cache1 = Cache::store("file")->get("123agung");
    $cache2 = Cache::store("file")->get("321agung");
    var_dump($cache1);
    echo "<br>";
    var_dump($cache2);
  }

  public function gambar(Request $req)
  {
    $category = $req->category;
    $size = $req->size;
    echo $size;
  }
}
