<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;

class HTMLParserService
{
    public function parseSteamLots(string $htmlContent): array
    {
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new DOMXPath($dom);

        $listings = $xpath->query('//div[contains(@id, "listing_")]');

        $results = [];
        $processedIds = [];

        foreach ($listings as $listing) {
            $listingId = $listing->getAttribute('id');

            if (in_array($listingId, $processedIds)) {
                continue;
            }
            $processedIds[] = $listingId;

            $item = [];

            $inspectLink = $xpath->query('.//a[contains(@href, "steam://rungame")]', $listing);
            if ($inspectLink->length > 0) {
                $inspectLink = $inspectLink->item(0)->getAttribute('href');
                $item = [
                    'inspect_link' => $inspectLink,
                    ...$this->parseInspectLink($inspectLink)
                ];
            }

            $priceWithFee = $xpath->query('.//span[@class="market_listing_price market_listing_price_with_fee"]', $listing);
            if ($priceWithFee->length > 0) {
                $price = trim($priceWithFee->item(0)->textContent);
                $item['price'] = $this->convertPriceToFloat($price);
                $item['price_dirty'] = $price;
            }


            if ($item) $results[] = $item;
        }

        return $results;
    }

    private function convertPriceToFloat($priceText): float
    {
        if (preg_match('/[0-9][0-9\s,.]*/', $priceText, $matches)) {
            $numberStr = $matches[0];

            $numberStr = str_replace(' ', '', $numberStr);

            $numberStr = str_replace(',', '.', $numberStr);

            return (float)$numberStr;
        }

        return 0.0;
    }

    private function parseInspectLink($inspectUrl): array
    {
        $params = [
            'm' => null,
            'a' => null,
            'd' => null
        ];

        if (preg_match('/M(\d+)A(\d+)D(\d+)/', $inspectUrl, $matches)) {
            $params['m'] = $matches[1];
            $params['a'] = $matches[2];
            $params['d'] = $matches[3];
        }

        return $params;
    }
}
