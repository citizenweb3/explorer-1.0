<?php

namespace App\Console\Commands;

use App\Models\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;

class GetValidatorsDelegators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:validators-delegators {validator?}';

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

            $validator = $this->argument('validator');

            $validators = Validator::query()
                ->when(!isset($validator), function ($query) {
                    return $query->where('status', 3);
                })
                ->when(isset($validator), function ($query, $validator) {
                    return $query->where('id', $validator);
                })
                ->get();

            $this->withProgressBar($validators, function($validator) {

                do {

                    $validator->delegators()->delete();

                    $limit = 60;
                    $offset = 0;

                    $validatorDelegators = Http::acceptJson()
                        ->get('https://api.mintscan.io/v1/cosmos/validators/'.$validator->operator_address.'/delegators', [
                            'limit' => $limit,
                            'offset' => $offset
                        ])
                        ->throw()
                        ->json();

                    // $validatorDelegators['height']
                    // $validatorDelegators['created_at']
                    // $validatorDelegators['total_count']

                    if (isset($validatorDelegators['delegators'])) {
                        foreach ($validatorDelegators['delegators'] as $delegator) {
                            $validator->delegators()->create($delegator);
                        }
                    }

                } while (isset($validatorDelegators['delegators']) && !empty($validatorDelegators['delegators']));

            });

        } catch (\Exception $exception) {
            $this->newLine();
            $this->error($exception->getMessage());
        }
    }
}
