<?php

namespace App\Enums;

enum PermissionsEnum: string
{
    case INTEGRATION_LIST = 'integrations.list';
    case INTEGRATION_SHOW = 'integrations.show';
    case INTEGRATION_CREATE = 'integrations.create';
    case INTEGRATION_EDIT = 'integrations.edit';
    case INTEGRATION_UPDATE = 'integrations.update';
    case INTEGRATION_DESTROY = 'integrations.destroy';
}
