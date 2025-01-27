<?php

namespace App\Services\Admin\Account;

use App\Models\AccountType;
use App\Repositories\Admin\Account\AccountTypeRepository;
use App\Repositories\Admin\Account\AccountTypeRepositoryInterface;



class AccountTypeFactory
{
    public static function createService(): AccountTypeServiceInterface
    {
        $repository = new AccountTypeRepository(new AccountType());
        return new AccountTypeService($repository);
    }
}
