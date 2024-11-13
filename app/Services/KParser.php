<?php

namespace App\Services;

class KParser extends AbstractParser
{
    protected function getStoreFileName(): string
    {
        return 'flats-list.json';
    }

    protected function getDocumentUrl(): string
    {
        return 'https://re.kufar.by/l/minsk/snyat/kvartiru-dolgosrochno/bez-posrednikov?cur=USD&oph=1&prc=r%3A250%2C400&size=30';
    }

    protected function getXpathQueryExpression(): string
    {
        return '/html/body/div[1]/div[2]/div[1]/main/div/div/div[5]/div[1]/div[4]/div/section';
    }
}
