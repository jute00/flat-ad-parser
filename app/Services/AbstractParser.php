<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

abstract class AbstractParser implements Parser
{
    private const TELEGRAM_URL = 'https://api.telegram.org/bot7543409418:AAHplcAYtcOBJjJi4Bnk9hMngM32di12BpQ/sendMessage?chat_id=-4576353735&parse_mode=HTML&text=';

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
                //$this->sendTelegramMessage($url);
            }
        }
        $this->storeUrlsList($processed_list);
    }

    protected function loadUrlList(): array
    {
        $dom = new \DOMDocument();
        $dom->loadHTML(file_get_contents($this->getDocumentUrl()));

        $xpath = new \DOMXPath($dom);
        $elements = $xpath->query($this->getXpathQueryExpression());

        $data = [];
        foreach ($elements as $title) {
            $data[] = $this->getUrlPrefix() . explode('?', $title->getElementsByTagName('a')[0]->getAttribute('href'))[0];
        }
        return $data;
    }

    protected function getUrlPrefix(): string
    {
        return '';
    }

    private function getUrlsList(): ?array
    {
        return json_decode(Storage::get($this->getStoreFileName()));
    }

    private function storeUrlsList(array $data)
    {
        Storage::put($this->getStoreFileName(), json_encode($data));
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

    abstract protected function getStoreFileName(): string;
    abstract protected function getDocumentUrl(): string;
    abstract protected function getXpathQueryExpression(): string;
}
