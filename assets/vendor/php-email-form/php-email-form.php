<?php
class PHP_Email_Form {
    public $to;
    public $from_name;
    public $from_email;
    public $subject;
    public $smtp = [];
    public $messages = [];
    public $ajax = false;

    public function add_message($content, $label, $priority = 0) {
        $this->messages[] = [
            'content' => $content,
            'label' => $label,
            'priority' => $priority
        ];
    }

    public function send() {
        $headers = "From: {$this->from_name} <{$this->from_email}>\r\n";
        $headers .= "Reply-To: {$this->from_email}\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $body = "You have received a new message:\n\n";
        foreach ($this->messages as $message) {
            $body .= "{$message['label']}: {$message['content']}\n";
        }

        if (!empty($this->smtp)) {
            return $this->send_via_smtp($body, $headers);
        }

        return mail($this->to, $this->subject, $body, $headers);
    }

    private function send_via_smtp($body, $headers) {
        // SMTP functionality can be implemented here using PHPMailer or similar libraries.
        return false; // For now, we'll just return false.
    }
}
?>
