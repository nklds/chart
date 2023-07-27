<?php

namespace App\Core;

class Response
{
    private string | array $data;
    private array $headers;

    public function __construct(App $app)
    {
    }

    private function shiftHeaders(): void
    {
        foreach ($this->headers as $header) {
            header($header['header'], true, $header['status']);
        }
    }

    public function addHeader(string $header, int $status): Response
    {
        $this->headers[] = ['header' => $header, 'status' => $status];
        return $this;
    }

    public function toJson(): Response
    {
        $this->setData(json_encode($this->getData(), JSON_UNESCAPED_SLASHES));
        return $this;
    }

    public function getData(): string | array
    {
        return $this->data;
    }

    public function setData(string | array $data): Response
    {
        $this->data = $data;
        return $this;
    }

    public function sendResponse(): void
    {
        $this->shiftHeaders();
        echo $this->getData();
    }

}