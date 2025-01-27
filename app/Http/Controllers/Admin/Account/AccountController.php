<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use App\Models\Purpose;
use App\Services\Admin\Account\AccountTypeServiceInterface;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountTypeService;

    public function __construct(AccountTypeServiceInterface $accountTypeService)
    {
        $this->accountTypeService = $accountTypeService;
    }

    public function index()
    {
        $accountTypes = $this->accountTypeService->getAllAccountTypes();
        return view('admin.account.index', compact('accountTypes'));
    }


    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|unique:account_types,name|max:255',
        ]);

        $this->accountTypeService->createAccountType($data);

        return back()->with('success', 'Account type added successfully!');
    }

    public function edit($accountType)
    {
        $accountType = $this->accountTypeService->getAccountType($accountType);
        return view('admin.account.edit', compact('accountType'));
    }

    public function update(Request $request, $accountType)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:account_types,name,' . $accountType . '|max:255',
        ]);

        $this->accountTypeService->updateAccountType($accountType, $data);

        return back()->with('success', 'Account type updated successfully!');
    }

    public function destroy($accountType)
    {
        $this->accountTypeService->deleteAccountType($accountType);

        return back()->with('success', 'Account type deleted successfully!');
    }

    //accountPurpose

    public function accountPurpose()
    {

         $purposes=$this->accountTypeService->getAllPurposes();
        return view('admin.account.accountPurpose', compact('purposes'));
    }

    public function addPurpose()
    {
        return view('admin.account.addPurpose');
    }

    public function storePurpose(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:purposes,name|max:255',
        ]);



        $this->accountTypeService->createPurpose($data);

        return back()->with('success', 'Account purpose added successfully!');
    }

    public function editPurpose($purpose)
    {
        $purpose = $this->accountTypeService->getPurpose($purpose);
        return view('admin.account.editPurpose', compact('purpose'));
    }

    public function updatePurpose(Request $request, $purpose)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:purposes,name,' . $purpose . '|max:255',
        ]);

        $this->accountTypeService->updatePurpose($purpose, $data);

        return back()->with('success', 'Account purpose updated successfully!');
    }

    public function destroyPurpose($purpose)
    {
        $this->accountTypeService->deletePurpose($purpose);

        return back()->with('success', 'Account purpose deleted successfully!');
    }
}
