<?php

namespace App\Services;

class ApiKeyService
{
    public function generateApiKeys(): array
    {
        $publicKey = 'er_pub_' . bin2hex(random_bytes(16));
        $secretKey = 'er_sec_' . bin2hex(random_bytes(32));

        return [
            'public_key'        => $publicKey,
            'secret_key'        => $secretKey,
            'secret_hash_store' => bcrypt($secretKey),
        ];
    }
}