<?php

namespace App\UseCases\ImportKeychainPricesJabka;

use App\Models\KeychainJabka;
use App\Services\JabkaSkinHTTPClient;

readonly class Handler
{
    private int $batchSize;

    public function __construct(private JabkaSkinHTTPClient $jabkaSkinHTTPClient){
        $this->batchSize = config('jabka_skin.client.batch_size');
    }


    public function handle(): void
    {
        $lastPage = 0;
        $page = 1;

        do{
            $response = $this->jabkaSkinHTTPClient->getKeychains($page, $this->batchSize);

            if (! $lastPage) $lastPage = $response['data']['paginationMetadata']['lastPage'];

            foreach ($response['data']['parentItems'] as $keychain){

                KeychainJabka::query()->updateOrCreate(['id' => $keychain['bestWearChild']['id']], [
                    'name' => $keychain['bestWearChild']['marketName'],
                    'price' => $keychain['bestWearChild']['steamPrice'],
                    'price_jabka' => $keychain['bestWearChild']['price'],
                    'colors' => $keychain['bestWearChild']['imageColors'],
                    'icon' => 'https://jabka.skin/cdn/items/' . $keychain['bestWearChild']['id'] . '/medium.png',
                ]);
            }

            $page++;
            sleep(3);
        }while ($lastPage >= $page);
    }
}
