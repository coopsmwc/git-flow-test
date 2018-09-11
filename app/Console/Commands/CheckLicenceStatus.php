<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Company;
use Illuminate\Support\Facades\Log;

class CheckLicenceStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'licence:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check organisation licence dates and set the licence_status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * Loop through the organisation and set their status based on licence start and end date.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (Company::all() as $company) {
            if ($company->licence_status === 'PENDING') {
                if (time() >= $company->getLicenceStartDateTimestamp()) {
                    $company->licence_status = 'ACTIVE';
                    $company->save();
                    Log::notice($company->name.' licence status set to ACTIVE.');
                }
            }
            
            if ($company->licence_status === 'ACTIVE') {
                if (time() >= $company->getLicenceEndDateTimestamp()) {
                    if ($company->auto_renew) {
                        $company->licence_start_date = strtotime(date("Y-m-d"));
                        $company->licence_end_date = strtotime(date("Y-m-d")) + (364 * 24 * 60 * 60);
                        Log::notice($company->name.' licence renewed.');
                    } else {
                        $company->licence_status = 'CANCELLED';
                        Log::notice($company->name.' licence status set to CANCELLED.');
                    }
                    $company->save();
                }
            }
            
            if (env('APP_DEBUG', false)) {
                Log::info($company->name);
            }
        }
    }
}
