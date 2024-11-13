<?php

namespace App\Services;

class RParser extends AbstractParser
{
    protected function getStoreFileName(): string
    {
        return 'realt-list.json';
    }

    protected function getDocumentUrl(): string
    {
        return 'https://realt.by/rent/flat-for-long/?addressV2=%5B%7B%22townUuid%22%3A%224cb07174-7b00-11eb-8943-0cc47adabd66%22%7D%5D&page=1&priceFrom=250&priceTo=400&priceType=840&seller=true';
    }

    protected function getXpathQueryExpression(): string
    {
        return '/html/body/div[1]/div[1]/div[1]/main/div/div/div/div/div[1]/div[3]/div[1]/div/div/div';
    }

    protected function getUrlPrefix(): string
    {
        return 'https://realt.by';
    }
}
