<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\User;

class IntegrationPolicy
{
    public function index(User $user)
    {
        return $user->can(PermissionsEnum::INTEGRATION_LIST->value);
    }

    public function show(User $user)
    {
        return $user->can(PermissionsEnum::INTEGRATION_SHOW->value);
    }

    public function create(User $user)
    {
        return $user->can(PermissionsEnum::INTEGRATION_CREATE->value);
    }

    public function edit(User $user)
    {
        return $user->can(PermissionsEnum::INTEGRATION_EDIT->value);
    }

    public function update(User $user)
    {
        return $user->can(PermissionsEnum::INTEGRATION_UPDATE->value);
    }

    public function destroy(User $user)
    {
        return $user->can(PermissionsEnum::INTEGRATION_DESTROY);
    }
}
