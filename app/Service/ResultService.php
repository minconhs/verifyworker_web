<?php

declare(strict_types=1);

namespace App\Service;

class ResultService
{
    public bool $status;

    public ?string $message;

    public mixed $data;

    public function __construct(bool $status = false, ?string $message = null,  mixed $data = null)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    public static function success(string $message, mixed $data = null): self
    {
        return new self(true, $message, $data);
    }

    public static function failure(string $message, mixed $data = null): self
    {
        return new self(false, $message, $data);
    }
}