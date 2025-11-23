<?php

namespace App\Domains\Mandate\Contracts;

interface MandateContract
{
    public function get(int $id);

    public function create(array $data);

    public function update(array $data);
}
