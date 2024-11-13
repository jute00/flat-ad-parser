<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ParserService
{
    const STORE_FILENAME = 'flats-list.json';
    const DOCUMENT_URL = 'https://re.kufar.by/l/minsk/snyat/kvartiru-dolgosrochno/bez-posrednikov?cur=USD&oph=1&prc=r%3A250%2C400&size=30';
    const TELEGRAM_URL = 'https://api.telegram.org/bot7543409418:AAHplcAYtcOBJjJi4Bnk9hMngM32di12BpQ/sendMessage?chat_id=-4576353735&parse_mode=HTML&text=';

    public function __construct()
    {
        libxml_use_internal_errors(true);
    }

    public function run()
    {
        $processed_list = $this->getUrlsList() ?? [];
        foreach ($this->loadUrlList() as $url) {
            if (!in_array($url, $processed_list)) {
                $processed_list[] = $url;
                $this->sendTelegramMessage($url);
            }
        }
        $this->storeUrlsList($processed_list);
    }

    private function loadUrlList(): array
    {
        $dom = new \DOMDocument();
        $dom->loadHTML(file_get_contents(self::DOCUMENT_URL));

        $xpath = new \DOMXPath($dom);
        $elements = $xpath->query('/html/body/div[1]/div[2]/div[1]/main/div/div/div[5]/div[1]/div[4]/div/section');

        $data = [];
        foreach ($elements as $title) {
            $data[] = explode('?rank', $title->getElementsByTagName('a')[0]->getAttribute('href'))[0];
        }
        return $data;
    }

    private function getUrlsList(): ?array
    {
        return json_decode(Storage::get(self::STORE_FILENAME));
    }

    private function storeUrlsList(array $data)
    {
        Storage::put(self::STORE_FILENAME, json_encode($data));
    }

    private function sendTelegramMessage(string $message)
    {
        $time = 0;
        while (true) {
            try {
                sleep($time++);
                file_get_contents(self::TELEGRAM_URL . $message);
                break;
            } catch (\Throwable $e) {
                //do nothing
            }
        }
    }
}
