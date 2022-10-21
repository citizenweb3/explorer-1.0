<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetValidatorsDelegators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:validators-delegators';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get validators delegators';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            $validators = Validator::where('status', 3)->get();

            $this->withProgressBar($validators, function($validator) {

                do {

                    $validatorDelegators = Http::acceptJson()
                        ->get('https://api.mintscan.io/v1/cosmos/validators/'.$validator->operator_address.'/delegators', [
                            'limit' => 60,
                            'offset' => 0
                        ])
                        ->throw()
                        ->json();

                    // $validatorDelegators['height']
                    // $validatorDelegators['created_at']
                    // $validatorDelegators['total_count']

                    foreach ($validatorDelegators['delegators'] as $delegator) {
                        $validator->delegators()->create($delegator);
                    }

                } while (!empty($validatorDelegators));

            });

        } catch (\Exception $exception) {
            $this->newLine();
            $this->error($exception->getMessage());
        }
    }
}
