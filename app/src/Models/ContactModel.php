<?php

declare (strict_types = 1);

namespace App\Models;

class ContactModel
{
    private string $name    = '';
    private string $email   = '';
    private string $reason  = '';
    private string $message = '';
    private array $errors   = [];

    /**
     * Set raw data
     */
    public function setData(array $data): void
    {
        $this->name    = trim(strip_tags($data['name'] ?? ''));
        $this->email   = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $this->reason  = trim(strip_tags($data['reason'] ?? ''));
        $this->message = trim(strip_tags($data['message'] ?? ''));
    }

    /**
     * Validate form data
     */
    public function validate(): bool
    {
        $this->errors = [];

        // Name validation
        if ($this->name === '') {
            $this->errors['name'] = 'Name is required.';
        } elseif (strlen($this->name) < 3) {
            $this->errors['name'] = 'Name must be at least 3 characters.';
        } elseif (strlen($this->name) > 55) {
            $this->errors['name'] = 'Name must not exceed 55 characters.';
        } elseif (is_numeric($this->name)) {
            $this->errors['name'] = 'Nane cannot be numeric.';
        }

        // Email validation
        if ($this->email === '') {
            $this->errors['email'] = 'Email is required.';
        } elseif (! filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Invalid email format.';
        }

        // Reason validation
        if ($this->reason === '') {
            $this->errors['reason'] = 'Reason is required.';
        } elseif (strlen($this->reason) < 5) {
            $this->errors['reason'] = 'Reason must be at least 5 characters.';
        } elseif (strlen($this->reason) > 55) {
            $this->errors['reason'] = 'Reason must not exceed 55 characters.';
        } elseif (is_numeric($this->reason)) {
            $this->errors['reason'] = 'Reason cannot be numeric.';
        }

        // Message validation
        if ($this->message === '') {
            $this->errors['message'] = 'Message is required.';
        } elseif (strlen($this->message) < 10) {
            $this->errors['message'] = 'Message must be at least 10 characters.';
        } elseif (strlen($this->message) > 1000) {
            $this->errors['message'] = 'Message must not exceed 1000 characters.';
        } elseif (is_numeric($this->message)) {
            $this->errors['message'] = 'Message cannot be numeric.';
        }

        return empty($this->errors);
    }

    /**
     * Get data for email
     */
    public function getData(): array
    {
        return [
            'name'    => $this->name,
            'email'   => $this->email,
            'reason'  => $this->reason,
            'message' => $this->message,
        ];
    }

    /**
     * Validation errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * if error, data displayed in the form.
     */
    public function getSanitisedData(): array
    {
        return [
            'name'    => htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8'),
            'email'   => htmlspecialchars($this->email, ENT_QUOTES, 'UTF-8'),
            'reason'  => htmlspecialchars($this->reason, ENT_QUOTES, 'UTF-8'),
            'message' => htmlspecialchars($this->message, ENT_QUOTES, 'UTF-8'),
        ];
    }

}
