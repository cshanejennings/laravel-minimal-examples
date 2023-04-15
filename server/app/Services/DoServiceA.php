<?php

namespace App\Services;

use App\Contracts\DoServiceInterface;

class DoServiceA implements DoServiceInterface {

    
    /**
     * {@inheritDoc}
     * @return string the string 'DoServiceA' as the name of this service
     */
    public function do(): string {
        return 'DoServiceA';
    }
}