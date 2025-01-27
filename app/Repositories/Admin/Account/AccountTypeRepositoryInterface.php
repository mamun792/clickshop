<?php

namespace App\Repositories\Admin\Account;

interface AccountTypeRepositoryInterface
{
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getAll();
    public function get($id);

    // purpose of this method is to get all account types for select dropdown
    public function createPurpose(array $data);
    public function updatePurpose($id, array $data);
    public function deletePurpose($id);
    public function getAllPurposes();
    public function getPurpose($id);
}
