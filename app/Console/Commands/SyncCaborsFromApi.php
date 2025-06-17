<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Cabor;

class SyncCaborsFromApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:cabors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting cabor synchronization...');
        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 30,
            ])->get('https://koni-kotabandung.or.id/api/cabor');

            if ($response->successful()) {
                $apiCabors = $response->json();
                $processedCount = 0;

                foreach ($apiCabors as $apiCabor) {
                    Cabor::updateOrCreate(
                        ['api_cabor_id' => $apiCabor['id_cabor']],
                        [
                            'nama_cabor' => $apiCabor['nama_cabor'],
                        ]
                    );
                    $processedCount++;
                }

                $this->info("Synchronization complete. Processed {$processedCount} cabors.");
                Log::info("Cabor synchronization successful. Processed {$processedCount} cabors.");
            } else {
                $this->error('Failed to fetch data from Koni API. Status: ' . $response->status());
                Log::error('Failed to fetch cabor data from Koni API. Status: ' . $response->status() . ' Body: ' . $response->body());
            }
        } catch (\Exception $e) {
            $this->error('An error occurred during synchronization: ' . $e->getMessage());
            Log::error('Cabor synchronization error: ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
