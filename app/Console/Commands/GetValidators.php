<?php

namespace App\Console\Commands;

use App\Models\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;

class GetValidators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:validators';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get validators';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            $response = Http::acceptJson()
                ->get('https://api.cosmostation.io/v1/staking/validators')
                ->throw()
                ->json();

            $validators = Arr::where($response, function ($value, $key) {
                return $value['status'] == 3;
            });

            $this->withProgressBar($validators, function($validator) {
                Validator::updateOrCreate(
                    ['account_address' => $validator['account_address']],
                    $validator
                );
            });

        } catch (\Exception $exception) {
            $this->newLine();
            $this->error($exception->getMessage());
        }
    }
}
