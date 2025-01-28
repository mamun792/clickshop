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

    //income
    public function income(Request $request)
    {

        $filters = $request->only(['startDate', 'endDate', 'account_type']);


        $allTransactions = $this->accountTypeService->getAllTransactions($filters);


        $credits = $this->accountTypeService->getAllCredits($filters);
        $debits = $this->accountTypeService->getAllDebits($filters);


        $accountTypes = $this->accountTypeService->getAllAccountTypes();

        // Calculate income (sum of credits), expenses (sum of debits), and balance (income - expense)
        $income = $credits->sum('amount');
        $expense = $debits->sum('amount');
        $balance = $income - $expense;


        $accountType = $accountTypes->count();
        return view('admin.account.income', compact('credits','debits','accountTypes','income','expense','balance','accountType'));
    }

    //credit
    public function credit()
    {
        $accountTypes = $this->accountTypeService->getAllAccountTypes();
        $purposes = $this->accountTypeService->getAllPurposes();
        return view('admin.account.credit', compact('accountTypes', 'purposes'));
    }

    //debit
    public function debit()
    {
        $accountTypes = $this->accountTypeService->getAllAccountTypes();
        $purposes = $this->accountTypeService->getAllPurposes();
        return view('admin.account.debit', compact('accountTypes', 'purposes'));
    }

    public function storeDebit(Request $request)
    {
        // return $request->all();
        $data = $request->validate([
            '_token' => 'required|string',
            'transaction_date' => 'required|date',
            'purpose_id' => 'required|exists:purposes,id',
            'amount' => 'required|numeric|min:0',
            'comments' => 'nullable|string|max:255',
            'account_id' => 'required|exists:account_types,id',
            'transaction_type' => 'required|in:credit,debit',
            'document' => 'nullable|file|mimes:jpeg,png,pdf',
        ]);


        $this->accountTypeService->storeDebit($data);

        return back()->with('success', 'Debit added successfully!');
    }

    public function balanceTransfer()
    {
        $accountTypes = $this->accountTypeService->getAllAccountTypes();
        return view('admin.account.balanceTransfer', compact('accountTypes'));
    }

    public function balanceTransferForm()
    {
        $accountTypes = $this->accountTypeService->getAllAccountTypes();
        return view('admin.account.balanceTransferForm', compact('accountTypes'));
    }
}
