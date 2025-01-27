<?php

namespace App\Services\Admin\Account;

interface AccountTypeServiceInterface
{
    public function createAccountType(array $data);
    public function updateAccountType($id, array $data);
    public function deleteAccountType($id);
    public function getAllAccountTypes();
    public function getAccountType($id);

    // purpose of this method is to get all account types for select dropdown
    public function createPurpose(array $data);
    public function updatePurpose($id, array $data);
    public function deletePurpose($id);
    public function getAllPurposes();
    public function getPurpose($id);

}
