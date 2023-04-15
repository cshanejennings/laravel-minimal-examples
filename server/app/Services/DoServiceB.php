<?php

namespace App\Services;

use App\Contracts\DoServiceInterface;

class DoServiceB implements DoServiceInterface {
    
    /**
     * {@inheritDoc}
     * @return string the string 'DoServiceB' as the name of this service
     */
    public function do(): string {
        return 'DoServiceB';
    }
}