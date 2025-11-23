<?php

namespace App\Domains\Mandate\Drivers;

use App\Domains\Mandate\Contracts\MandateContract;

final class C2pMandateDriver implements MandateContract
{
    public function get(int $id)
    {
        /** find mandate by id and return it */
        return $id;
    }

    public function create(array $data)
    {
        /** call payment providers to generate link */
        return '2c2p payment link';
    }

    public function update(array $data)
    {
        /** update mandate here */
    }
}
