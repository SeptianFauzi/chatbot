<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Flow;
use App\Models\TempoQuiz;
use App\Models\LogQuiz;

use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINE\LINEBot\Event\Parser\EventRequestParser;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;

use DB;

class QuizController extends Controller
{
    private $bot;

    public function __construct()
    {
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(env("LINE_ACCES_TOKEN"));
        $this->bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env("LINE_CHANNEL_SECRET")]);
    }

    public function onTimeQuiz($lineId, $replyToken, $active)
    {
        if($active) {
            $fl = LogQuiz::where('line_id', $lineId)->first();
            if($fl) {
                $response = $this->bot->replyMessage(
                    $replyToken,
                    (new MultiMessageBuilder())
                    ->add(new TextMessageBuilder("Kuis hanya berlaku satu kali untuk setiap akun"))
                );
                return $response;
            }
        }
    }
    
    public function startQuiz($lineId, $replyToken, $userMessage, $datas)
    {
        $once = $this->onTimeQuiz($lineId, $replyToken, false); // set to false for unlimited quiz
        if(!$once) {$this->setTopic($lineId,"QuizController", NULL, "selectQuiz", NULL);}

        $openingImage = "https://i.ibb.co/CV4VpY0/Tempo-Challenge.jpg";
        $openingText = "Yuk, coba cari kata yang mewakili kanal kesukaan kamu di website TEMPO.CO, akan ada pertanyaan setelah kamu memilih salah satu kanal tersebut.\n\ncontoh , disaat kamu menjawab “TRAVEL” Akan langsung ada pertanyaan seputar kanal Travel seperti:Ternyata, ada satu tempat wisata di daerah ini yang bisa juga disebut dengan Wisata Antikemapanan, apa nama daerah tersebut? Untuk tahu jawabannya kamu bisa klik: http://bit.ly/2DBKEw2\nA. Hue\nB. Hoi An\nC. Sapa\nD. Quy Nhon\n\ndan jika kamu menjawab “D. Quy Nhon ( jawaban benar ) maka akan langsung muncul link form registrasi untuk bisa ikut undian hadiah sepeda dari Tempo dan kamu langsung bisa mendapatkan langganan majalah Tempo Digital selama 1 bulan. ";

        $response = $this->bot->replyMessage(
            $replyToken,
            (new MultiMessageBuilder())
            ->add(new ImageMessageBuilder($openingImage, $openingImage))
            ->add(new TextMessageBuilder($openingText))
        );

        return $response;
    }
    
    public function selectQuiz($lineId, $replyToken, $userMessage, $datas)
    {
        $quiz = TempoQuiz::where("keyword",strtolower($userMessage))->first();
        try {
            if($quiz) {

                if($quiz["answer"] == "-") {
                    $quiz->count_failed = 0;
                    $quiz->is_unique = 1;
                    $this->setTopic($lineId,"QuizController", "checkAnswers", "getUserEmail" , (string)json_encode($quiz));
                    $response = $this->uniqueQuiz($lineId, $replyToken, $userMessage, $datas);
                    return $response;
                }

                $this->setTopic($lineId,"QuizController", "startQuiz", "checkAnswers" , (string)$quiz);                
                $titleImageMap = "Tempo Quiz";
                $question = $quiz["question"];
                $optionA = $quiz["option_a"];
                $optionB = $quiz["option_b"];
                $optionC = $quiz["option_c"];
                $optionD = $quiz["option_d"];
                $optionAssets = $quiz["asset"];
                $answer = $quiz["answer"];
                
                $response = $this->bot->replyMessage(
                    $replyToken,
                    (new MultiMessageBuilder())
                    ->add(new TextMessageBuilder($question))
                    ->add( new ImagemapMessageBuilder(
                        $optionAssets,
                        $titleImageMap,
                        new BaseSizeBuilder(1040, 1040),
                        [
                            new ImagemapMessageActionBuilder(
                                $optionA,
                                new AreaBuilder(0, 9, 523, 499)
                            ),
                            new ImagemapMessageActionBuilder(
                                $optionC,
                                new AreaBuilder(0, 508, 524, 457)
                            ),
                            new ImagemapMessageActionBuilder(
                                $optionD,
                                new AreaBuilder(525, 508, 513, 463)
                            ),
                            new ImagemapMessageActionBuilder(
                                $optionB,
                                new AreaBuilder(525, 9, 503, 495)
                            ),
                        ]
                    ))
                );
        
                return $response;
            }else {
                $response = $this->bot->replyMessage(
                    $replyToken,
                    (new MultiMessageBuilder())
                    ->add(new TextMessageBuilder("Maaf Topic yang kamu pilih tidak ada, silahkan coba yang lain ya.."))
                );
                return $response;
            }
        } catch (\Throwable $th) {
            file_put_contents(storage_path() . '/logs/error_log_'.date('Ymd').'.log', $th . PHP_EOL, FILE_APPEND);
        }
       
    }

    public function checkAnswers($lineId, $replyToken, $userMessage, $datas)
    {
        $id = Flow::where('line_id', $lineId)->first();
        $dataQuestion = json_decode($id["data"],true);
        $answer = explode(".", $userMessage)[0];
        $answerDB = TempoQuiz::where("id", $dataQuestion["id"])->first();

        if( strtoupper($answer) == $answerDB["answer"]) {
            $userData = json_decode($id["data"],true);
            $userData = (object)$userData;
            $userData->count_failed = isset($dataQuestion["count_failed"]) ? $dataQuestion["count_failed"] : 0;
            $userData->is_unique = 0;
            $this->setTopic($lineId,"QuizController", "checkAnswers", "getUserEmail" , (string)json_encode($userData));

            $response = $this->correctAnswer($lineId, $replyToken, $userMessage, $datas);
        }else {
            if(isset($dataQuestion["count_failed"]) && $dataQuestion["count_failed"] > 0) {
                // delete flow if user failed more than 1
                Flow::where(['line_id' => $lineId ])->delete();
                $response = $this->bot->replyMessage(
                    $replyToken,
                    (new MultiMessageBuilder())
                    ->add(new TextMessageBuilder("Maaf ya.. kesempatan kamu udah habis, silahkan coba lagi dari awal.."))
                );
                return $response;
            }else {
                // counting failed answer
                $dataQuestion = (object)$dataQuestion;
                $dataQuestion->count_failed = 1;
                $dataQuestion->is_unique = 0;
                $this->setTopic($lineId,"QuizController", "startQuiz", "checkAnswers" , (string)json_encode($dataQuestion));
                $response = $this->wrongAnswer($lineId, $replyToken, $userMessage, $datas);
            }
        }

    }

    public function uniqueQuiz($lineId, $replyToken, $userMessage, $datas)
    {
        $assetCorrect = "https://i.ibb.co/0GDmCLD/congratulation.jpg";
        $response = $this->bot->replyMessage(
            $replyToken,
            (new MultiMessageBuilder())
            ->add(new ImageMessageBuilder($assetCorrect, $assetCorrect))
            ->add(new TextMessageBuilder("SELAMAT, KAMU LANGSUNG MASUK DALAM BOX UNDIAN"))
            ->add(new TextMessageBuilder("Aku minta data kamu untuk pengumuman pemenangnya ya"))
            ->add(new TextMessageBuilder("Nama lengkap kamu siapa?"))
        );

        return $response;
    }

    public function correctAnswer($lineId, $replyToken, $userMessage, $datas)
    {
        $assetCorrect = "https://i.ibb.co/0GDmCLD/congratulation.jpg";
        $response = $this->bot->replyMessage(
            $replyToken,
            (new MultiMessageBuilder())
            ->add(new ImageMessageBuilder($assetCorrect, $assetCorrect))
            ->add(new TextMessageBuilder("Yeay jawaban kamu benar, selamat ya..."))
            ->add(new TextMessageBuilder("Aku minta data kamu untuk pengumuman pemenangnya ya"))
            ->add(new TextMessageBuilder("Nama lengkap kamu siapa?"))
        );

        return $response;
    }

    public function wrongAnswer($lineId, $replyToken, $userMessage, $datas)
    {
        $response = $this->bot->replyMessage(
            $replyToken,
            (new MultiMessageBuilder())
            ->add(new TextMessageBuilder("Maaf ya jawaban kamu salah nih..."))
            ->add(new TextMessageBuilder("Silahkan klik jawaban kamu dengan benar, yuk coba lagi ya..."))
        );

        return $response;
    }

    public function getUserEmail($lineId, $replyToken, $userMessage, $datas)
    {   
        if(preg_match('/(quiz|kuis|kuiz|quis)/',strtolower($userMessage))){
            $response = $this->bot->replyMessage(
                $replyToken,
                (new MultiMessageBuilder())
                ->add(new TextMessageBuilder("Nama lengkap kamu siapa?"))
            );
            return $response;
        }

        $userData = Flow::where('line_id', $lineId)->first();
        $userData = json_decode($userData["data"],true);
        $userData = (object)$userData;
        $userData->name = $userMessage;
        $this->setTopic($lineId,"QuizController", "getUserEmail", "getNoTelp" , (string)json_encode($userData));
        
        $response = $this->bot->replyMessage(
            $replyToken,
            (new MultiMessageBuilder())
            ->add(new TextMessageBuilder("Email kamu apa?"))
        );

        return $response;
    }

    public function getNoTelp($lineId, $replyToken, $userMessage, $datas)
    {
        // email validation
        if(!filter_var($userMessage, FILTER_VALIDATE_EMAIL)) {
            $response = $this->bot->replyMessage(
                $replyToken,
                (new MultiMessageBuilder())
                ->add(new TextMessageBuilder("Format email salah, silahkan coba lagi"))
            );

            return $response;
        }

        $userData = Flow::where('line_id', $lineId)->first();
        $userData = json_decode($userData["data"],true);
        $userData = (object)$userData;
        $userData->email = $userMessage;
        $this->setTopic($lineId,"QuizController", "getNoTelp", "saveAllData" , (string)json_encode($userData));

        $response = $this->bot->replyMessage(
            $replyToken,
            (new MultiMessageBuilder())
            ->add(new TextMessageBuilder("Kalau nomer telepon kamu berapa?"))
        );

        return $response;
    }

    public function saveAllData($lineId, $replyToken, $userMessage, $datas)
    {
        // telp validation
        if(!preg_match('/^[0-9]{10,13}+$/', $userMessage)) {
            $response = $this->bot->replyMessage(
                $replyToken,
                (new MultiMessageBuilder())
                ->add(new TextMessageBuilder("Nomor telepon tidak valid, silahkan coba lagi"))
            );
            return $response;
        }

        $userData = Flow::where('line_id', $lineId)->first();
        $userData = json_decode($userData["data"],true);
        $userData = (object)$userData;
        $userData->telp = $userMessage;
        $this->setTopic($lineId,"QuizController", "saveAllData", "saveAllData" , (string)json_encode($userData));
        $this->updateDataUser($lineId, $userData->name, $userData->email, $userData->telp);
        $this->saveLogQuiz("Tempo Challenge",$lineId, $userData->keyword, $userData->count_failed, $userData->is_unique);

        $response = $this->bot->replyMessage(
            $replyToken,
            (new MultiMessageBuilder())
            ->add(new TextMessageBuilder("Oke sudah aku catat, terimakasih sudah mengikuti Quiz Tempo.co. Semoga kamu beruntung ya!"))
        );
        
        Flow::where(['line_id' => $lineId ])->delete();

        return $response;
    }

    public function setTopic($lineId, $flowName, $lastTopic, $nextTopic, $data)
    {
        $fl = Flow::where('line_id', $lineId)->first();
        if($fl) {
            $ofl = Flow::where('line_id', $lineId)->first();
            $ofl->flow_name = $flowName;
            $ofl->last_topic = $lastTopic;
            $ofl->next_topic = $nextTopic;
            $ofl->data = $data;
            $ofl->save();
        }else {
            $nflow = new Flow;
            $nflow->line_id = $lineId;
            $nflow->flow_name = $flowName;
            $nflow->last_topic = $lastTopic;
            $nflow->next_topic = $nextTopic;
            $nflow->data = $data;
            $nflow->save();
        }
    }

    public function updateDataUser($lineId, $name, $email, $telp)
    {
        $u = User::where('line_id', $lineId)->first();
        $u->display_name = $name;
        $u->email = $email;
        $u->telp = $telp;
        $u->save();
    }

    public function saveLogQuiz($title, $lineId, $topicQuiz, $countFailed, $isUnique)
    {
        $lq = new LogQuiz;
        $lq->title = $title;
        $lq->line_id = $lineId;
        $lq->topic_quiz = $topicQuiz;
        $lq->count_failed = $countFailed;
        $lq->is_unique = $isUnique;
        $lq->save();
    }
}
