<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class SendEmailController extends BaseController
{

  public function verify(Request $request)
  {
    $token= $request->token;

    if(true) {
      return view('registerForm');
    }else 
    {
      return view('verificationFailed');
    }
  }

  public function emailVerification()
  {
    return view('mail/emailVerification', [
      'name' => 'Zero',
      'linkVerification' => 'https://google.com' 
    ]);
  }

}
