<?php
declare (strict_types = 1);

namespace App\Services;

class EmailService
{
    private string $to      = '';
    private string $subject = '';
    private string $body    = '';
    private array $headers  = [];

    /**
     * Set recipient
     */
    public function setTo(string $to): self
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Set subject
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Set body
     */
    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Add header
     */
    public function addHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Send the email
     */
    public function send(): bool
    {
        try {
            if (empty($this->to) || empty($this->subject) || empty($this->body)) {
                throw new \Exception('To, Subject, and Body must be set.');
            }

            $defaultHeaders = [
                'MIME-Version' => '1.0',
                'Content-Type' => 'text/plain; charset=UTF-8',
            ];

            $allHeaders = array_merge($defaultHeaders, $this->headers);

            $headers = '';
            foreach ($allHeaders as $key => $value) {
                $headers .= "{$key}: {$value}\r\n";
            }

            if (! mail($this->to, $this->subject, $this->body, $headers)) {
                throw new \Exception('Email sending failed');
            }

            return true;

        } catch (\Throwable $e) {
            // Optionally log error
            // error_log($e->getMessage());
            return false;
        }
    }
}
