<?php

namespace Hercules\AlistURLSigner;

class Signer
{
    private string $baseUri;
    private string $token;

    public function __construct(string $host, string $token, string $baseUri = '/d', bool $isHttps = true)
    {
        $this->baseUri = ($isHttps ? 'https://' : 'http://') . $host . $baseUri;
        $this->token = $token;
    }

    public function sign(string $url, int $expires = 0): string
    {
        $sign = $this->safeBase64Encode($this->str2bin(hash_hmac('SHA256', sprintf('%s:%d', $url, $expires), $this->token)));
        return sprintf('%s?sign=%s:%d', $this->baseUri, $sign, $expires);
    }

    private function safeBase64Encode(string $data): string
    {
        return strtr(base64_encode($data), '+/', '-_');
    }

    private function str2bin($hexdata)
    {
        $bindata = "";
        for ($i = 0; $i < strlen($hexdata); $i += 2) {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }
        return $bindata;
    }
}
