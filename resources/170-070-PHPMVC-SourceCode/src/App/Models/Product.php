<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Model;

class Product extends Model
{
    // protected $table = "products";

    protected array $errors = [];

    protected function addError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }

    protected function validate(array $data): bool
    {
        if (empty($data["name"])) {
            
            $this->addError("name", "Name is required");

        }

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
    
}