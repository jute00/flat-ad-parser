<?php

namespace App\Services;

class OParser extends AbstractParser
{
    protected function getStoreFileName(): string
    {
        return 'onliner-list.json';
    }

    protected function getDocumentUrl(): string
    {
        return 'https://r.onliner.by/ak/?price%5Bmin%5D=250&price%5Bmax%5D=400&currency=usd&metro%5B%5D=red_line&metro%5B%5D=blue_line&metro%5B%5D=green_line&only_owner=true#bounds%5Blb%5D%5Blat%5D=53.79821757312943&bounds%5Blb%5D%5Blong%5D=27.365226745605472&bounds%5Brt%5D%5Blat%5D=53.99949568180132&bounds%5Brt%5D%5Blong%5D=27.68692016601563&order=created_at:desc';
    }

    protected function getXpathQueryExpression(): string
    {
        return '';
    }

    protected function loadUrlList(): array
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->getDocumentUrl());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($curl));

        $data = [];
        foreach ($result->apartments ?? [] as $item) {
            $data[] = $item->url;
        }
        return $data;
    }
}
