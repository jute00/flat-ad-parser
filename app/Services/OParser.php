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
        return 'https://r.onliner.by/sdapi/ak.api/search/apartments?price[min]=200&price[max]=400&currency=usd&only_owner=true&bounds[lb][lat]=53.84462779782495&bounds[lb][long]=27.381706237792972&bounds[rt][lat]=53.96578102161269&bounds[rt][long]=27.70339965820313&order=created_at:desc&page=1&v=0.6306061828305893';
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
        foreach ($result->apartments as $item) {
            $data[] = $item->url;
        }
        return $data;
    }
}
