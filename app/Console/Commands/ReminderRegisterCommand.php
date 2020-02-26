<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

use App\Models\User;

/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class ReminderRegisterCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    
    // argument
    // protected $signature = "example:text {name}";
    // argument default value
    // protected $signature = "example:text {name=abc}";
    protected $signature = "bot:rr";


    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Reminder Register";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $users = $this->getUsers();
      
      if(count($users) != 0) {
        foreach ($users as $user) {
          echo $user->line_id;
          $this->pushReminder($user->line_id);
        }
      }

    }

    public function getUsers()
    {
      try {
        $users = User::where(function($user){
          $user->whereNull('email');
          $user->orWhereNull('year_of_birth');
          $user->orWhereNull('gender');
        })->where(['is_registered'=> 0, 'is_verified'=> 0])->get();
          
        return $users;
      } catch (\Throwable $th) {
        file_put_contents(storage_path() . '/logs/error_log_'.date('Ymd').'.log', $th . PHP_EOL, FILE_APPEND);
        echo "error";
      }
    }

    function pushReminder($line_id) 
    {
        $client = new GuzzleClient();
        $endpoint = "https://api.line.me/v2/bot/message/multicast";
        
        try {
            $exec = $client->request('POST', $endpoint, [
                'headers' =>  [
                  'authorization'=> 'Bearer '.env("LINE_ACCES_TOKEN"),
                  'content-type'=> 'application/json',
                ],
                'json' => [
                  "to"=> [$line_id],
                  "messages"=>[
                    [
                      "type"=> "text",
                      "text"=> "Anda belum menyelesaikan proses registrasi, silahkan klik tombol dibawah ini"
                    ],
                    [
                      "type"=> "template",
                      "altText"=> "Lanjutkan Registrasi",
                      "template"=> [
                        "type"=> "confirm",
                        "text"=> "Lanjutkan Registrasi",
                        "actions"=> [
                          [
                            "type"=> "uri",
                            "label"=> "Ya",
                            "uri"=> env("LINE_LIFF_URL")."?id=".$line_id
                          ],
                          [
                            "type"=> "message",
                            "label"=> "Tidak",
                            "text"=> "tidak"
                          ]
                        ]
                      ]
                    ]
                  ]
                ]
              ]
              
            );
            
        } catch (RequestException $e) {
          file_put_contents(storage_path() . '/logs/error_log_'.date('Ymd').'.log', $e . PHP_EOL, FILE_APPEND);
          echo "Failed fetch data";
        }
    }
}
