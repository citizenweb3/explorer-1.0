<?php

namespace App\Console\Commands;

use App\Models\Validator;
use App\Models\ValidatorEvent;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;

class GetValidatorsEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:validators-events {validator?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get validators events';

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

                    $lastEventId = ValidatorEvent::where('validator_id', $validator->id)->max('id');

                    if (!$lastEventId) {
                        $lastEventId = 0;
                    }

                    $validatorEvents = Http::acceptJson()
                        ->get('https://api.cosmostation.io/v1/staking/validator/events/'.$validator->operator_address, [
                            'limit' => 50,
                            'from' => $lastEventId
                        ])
                        ->throw()
                        ->json();

                    foreach ($validatorEvents as $event) {
                        $validator->events()->create($event);
                    }

                } while (!empty($validatorEvents));

            });

        } catch (\Exception $exception) {
            $this->newLine();
            $this->error($exception->getMessage());
        }
    }
}
