<?php
namespace MiniMailer;

class PHPMailer
{
    public $Host;
    public $Port;
    public $Username;
    public $Password;
    public $From;
    public $FromName;
    public $Subject;
    public $Body;
    public $to = [];

    private $smtp;

    public function isSMTP()
    {
        $this->smtp = new SMTP();
    }

    public function setFrom($email, $name = '')
    {
        $this->From = $email;
        $this->FromName = $name;
    }

    public function addAddress($email)
    {
        $this->to[] = $email;
    }

    public function send()
    {
        if (!$this->smtp) return false;

        $this->smtp->connect($this->Host, $this->Port);

        $this->smtp->sendCommand("HELO localhost");
        $this->smtp->sendCommand("AUTH LOGIN");
        $this->smtp->sendCommand(base64_encode($this->Username));
        $this->smtp->sendCommand(base64_encode($this->Password));

        $this->smtp->sendCommand("MAIL FROM:<{$this->From}>");
        $this->smtp->sendCommand("RCPT TO:<{$this->to[0]}>");
        $this->smtp->sendCommand("DATA");

        $msg =
            "From: {$this->FromName} <{$this->From}>\r\n" .
            "To: {$this->to[0]}\r\n" .
            "Subject: {$this->Subject}\r\n" .
            "Content-Type: text/html\r\n\r\n" .
            "{$this->Body}\r\n.\r\n";

        fwrite($this->smtp->getSocket(), $msg);

        $this->smtp->sendCommand("");
        $this->smtp->close();

        return true;
    }
}
