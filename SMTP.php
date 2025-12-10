<?php
namespace MiniMailer;

class SMTP
{
    private $socket;

    public function connect($host, $port)
    {
        $this->socket = fsockopen($host, $port, $errno, $errstr, 10);
        if (!$this->socket) {
            throw new Exception("Gagal connect. $errstr ($errno)");
        }
        $this->getResponse();
    }

    public function sendCommand($cmd)
    {
        fwrite($this->socket, $cmd . "\r\n");
        return $this->getResponse();
    }

    private function getResponse()
    {
        $data = "";
        while ($str = fgets($this->socket, 515)) {
            $data .= $str;
            if (substr($str, 3, 1) == ' ') break;
        }
        return $data;
    }

    public function close()
    {
        fclose($this->socket);
    }

    public function getSocket()
    {
        return $this->socket;
    }
}
