<?php

declare(strict_types=1);

namespace Framework;

class Response
{
    private string $body = "";

    public function setBody(string $body): void
    {
        $this->body = $body;
    }
    
    public function getBody(): string
    {
        return $this->body;
    }

    public function send(): void
    {
        echo $this->body;
    }
}