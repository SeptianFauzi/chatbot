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

/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class ExampleCommand extends Command
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
    protected $signature = "example:test";


    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Example description";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $msg = "Success schedule";
      echo "Example response";
      file_put_contents(storage_path() . '/logs/test_schedule.log', $msg . PHP_EOL, FILE_APPEND);

      // use argument
      // $this->argument("name");
    }
}
