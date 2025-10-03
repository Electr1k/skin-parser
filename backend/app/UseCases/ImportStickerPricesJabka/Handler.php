<?php

namespace App\UseCases\ImportStickerPricesJabka;

use App\Models\StickerJabka;
use App\Services\JabkaSkinHTTPClient;
use Exception;

class Handler
{
    private int $batchSize;

    public function __construct(private readonly JabkaSkinHTTPClient $jabkaSkinHTTPClient){
        $this->batchSize = config('jabka_skin.client.batch_size');
    }


    public function handle(): void
    {
        $lastPage = 0;
        $page = 1;

        do{
            $response = $this->jabkaSkinHTTPClient->getStickers($page, $this->batchSize);

            if (! $lastPage) $lastPage = $response['data']['paginationMetadata']['lastPage'];

            foreach ($response['data']['parentItems'] as $stickerData){

                StickerJabka::query()->updateOrCreate(['id' => $stickerData['bestWearChild']['id']], [
                    'name' => $stickerData['bestWearChild']['marketName'],
                    'price' => $stickerData['bestWearChild']['steamPrice'],
                    'price_jabka' => $stickerData['bestWearChild']['price'],
                    'colors' => $stickerData['bestWearChild']['imageColors'],
                    'icon' => 'https://jabka.skin/cdn/items/' . $stickerData['bestWearChild']['id'] . '/medium.png',
                ]);
            }

            $page++;
            sleep(3);
        }while ($lastPage >= $page);
    }
}
