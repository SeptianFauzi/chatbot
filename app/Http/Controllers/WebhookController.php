<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Flow;

use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\FollowEvent;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINE\LINEBot\Event\Parser\EventRequestParser;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;


use DB;

class WebhookController extends Controller
{
  private $bot;
  // private $accessToken = env("LINE_ACCES_TOKEN");
  // private $channelSecret = env("LINE_CHANNEL_SECRET");

  public function __construct()
  {
    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(env("LINE_ACCES_TOKEN"));
    $this->bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env("LINE_CHANNEL_SECRET")]);
  }

  private function getName($lineId) 
  {
    
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.line.me/v2/bot/profile/".$lineId,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Bearer ".env("LINE_ACCES_TOKEN"),
		  ),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
    curl_close($curl);
    
		if ($err) {
		  return 'error';
		} else {
      return $response;
		}

  }

  private function userIsExist($lineId) {
    $user = User::select('id')->where(['line_id' => $lineId])->get();
    return $user;
  }

  private function saveUser($dataUser, $type) 
  {
    $isExist = count($this->userIsExist($dataUser['userId']));
    if($isExist == 0) {
      $user = new User;
      $user->line_id = $dataUser['userId'];
      $user->display_name = $dataUser['displayName'];
      $user->picture_url = $dataUser['pictureUrl'];
      $user->type = $type == 'follow' ? 'new' : 'old';
      $user->save();
      return $user;
    }else {
      return [];
    }

  }

  private function sendMessage($replyToken, $message) 
  {
    $text = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
    return $this->bot->replyMessage($replyToken, $text);
  }

  private function emoji($code)
  {
    $bin = hex2bin(str_repeat('0', 8 - strlen($code)) . $code);
    return  mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
  }

  public function userMessageLog($datas)
  {
    file_put_contents(storage_path() . '/logs/log_line_bot_'.date('Ymd').'.log', $datas . PHP_EOL, FILE_APPEND);
  }

  public function errorLog($th)
  {
    file_put_contents(storage_path() . '/logs/error_log_'.date('Ymd').'.log', $th . PHP_EOL, FILE_APPEND);
  }

  private function expireFlow($lastTime)
  {
    // cek expire flow
    $datetime1 = strtotime($lastTime);
    $datetime2 = strtotime(date("Y-m-d H:i:s"));
    $interval  = abs($datetime2 - $datetime1);
    $expire   = round($interval / 60);
    return $expire;
  }

  private function runFlow($checkFlow, $lineId, $replyToken, $userMessage, $datas)
  {
    try {
      $class =  "App\Http\Controllers\\".$checkFlow["flow_name"];
      $nameFlow = new $class;
      $response = call_user_func_array(array($nameFlow, $checkFlow["next_topic"]), [$lineId, $replyToken, $userMessage, $datas]);
      return $response;
      
    } catch (\Throwable $th) {
      $this->errorLog($th);
    }
  }

  public function bot(Request $req)
  {
    $signature =  $req->header(HTTPHeader::LINE_SIGNATURE);
    $datas = $req->getContent();
    $deCode = json_decode($datas,true);

    $this->userMessageLog($datas);

    if(!empty($signature)){
      try {
        $events = $this->bot->parseEventRequest($req->getContent(), $signature);
      } catch (\Throwable $th) {
        $this->errorLog($th);
      } 

      try {

        foreach ($events as $event) {

          $type = $event->getType();
          $lineId =  $event->getUserId();
          $userName = json_decode($this->getName($lineId),true)["displayName"];
          $replyToken = $event->getReplyToken();

          if (!($event instanceof MessageEvent)) {
            // Non message event has come
            if($event instanceof FollowEvent){
              // save user by type follow/new user
              $dataUser = json_decode($this->getName($lineId),true);
              $this->saveUser($dataUser, $type);
              $this->userMessageLog("followed");
              // $response = $this->sendMessage($replyToken, 'Hi '.$dataUser["displayName"]);

              $response = $this->bot->replyMessage(
                $replyToken,
                (new MultiMessageBuilder())
                ->add(new TextMessageBuilder("Hai, selamat datang ".$dataUser["displayName"]." di akun resmi Tempo di LINE.\n\nSaya, Tara, akan membantu Anda mengetahui kabar terbaru tentang hal-hal penting yang ingin Anda ketahui. Namun sebelumnya, mohon melakukan registrasi terlebih dahulu dengan mengklik tombol di bawah ini, untuk membantu kami mempersiapkan menu informasi yang sesuai dengan kebutuhan dan keinginan Anda."))
                ->add(new TemplateMessageBuilder(
                    "Registrasi",
                    new ButtonTemplateBuilder(
                      "Registrasi",
                      "Silahkan klik untuk melakukan Registrasi",
                      "",
                      [new UriTemplateActionBuilder("Registrasi", env("LINE_LIFF_URL")."?id=".$lineId)]
                    )
                ))
              );

            }

          } else {

            if($event instanceof TextMessage) {
              $userMessage = $event->getText();
              $checkFlow = Flow::where('line_id', $lineId)->first();

              if($checkFlow){
                if(!($this->expireFlow($checkFlow->updated_at) > 5)) {
                  $response = $this->runFlow($checkFlow, $lineId, $replyToken, $userMessage, $datas);
                }else {
                  $response = $this->sendMessage($replyToken, 'Maaf waktu kamu telah habis, silakan ulangi kuis tempo dengan mengetikan "Ikuti Kuis" dan ikuti langkah selanjutnya.');
                  Flow::where(['line_id' => $lineId ])->delete();
                }
              }else {
                  // save user by type message/old user
                  $dataUser = json_decode($this->getName($lineId),true);
                  $this->saveUser($dataUser, $type);
                  
                  // simple flow
                  if(strtolower($event->getText()) == 'hi') {
                    $response = $this->sendMessage($replyToken, '');
                    // $response = $this->sendMessage($replyToken, 'hi juga '.$this->emoji("10008D"));

                  }else if(preg_match('/(quiz|kuis|kuiz|quis)/',strtolower($event->getText()))) {
  
                    $quiz = new QuizController;
                    $response = $quiz->startQuiz($lineId, $replyToken, $userMessage, $datas);
  
                  }else {
                    // $response = $this->sendMessage($replyToken, '');
                    $defaultResponse = "Terima kasih atas pesannya, ya! maaf kami belum bisa balas pesan kamu. ".$this->emoji("100094")." Kapan-kapan kita Live Chat, ya! ".$this->emoji("10008F")." \nUntuk informasi terbaru bisa cek langsung ke www.tempo.co atau Line Official Account kami.\n\nJangan lupa komen dan share, ya! ".$this->emoji("100033") .$this->emoji("10008D");
                    $response = $this->sendMessage($replyToken, $defaultResponse);
                  }
  
              }
            }

            if (!($event instanceof TextMessage)) {
              //Non text message has come
              continue;
            }
            
          }
   
          // if ($response->isSucceeded()) {
          //   echo 'Succeeded!';
          //   return;
          // }

          // echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
          // echo $response->getRawBody();

        }

      } catch (\Throwable $th) {
        $this->errorLog($th);
      }

    }

    http_response_code(200);
    return 'OK';
    
  }

}
