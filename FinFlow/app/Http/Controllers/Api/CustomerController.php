<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\Customer;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Requests\UpdateCustomerStatusRequest;
use App\Services\WalletServiceClient;
use App\Http\Resources\CustomerResource;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Customer::class);
    return Customer::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
    StoreCustomerRequest $request,
    WalletServiceClient $walletService
) {
    $data = $request->validated();

    $customer = Customer::create($data);

    $walletService->createWallet($customer->id);

    return new CustomerResource($customer);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    
    $customer = Customer::findOrFail($id);
   Gate::authorize('view', $customer);
    return response()->json($customer);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id)
{
    $customer = Customer::findOrFail($id);
    Gate::authorize('update', $customer);

    $customer->update($request->validated());

    return response()->json($customer);
}

   public function updateStatus(UpdateCustomerStatusRequest $request, string $id)
{
    $customer = Customer::findOrFail($id);
    Gate::authorize('updateStatus', $customer);
    $customer->update($request->validated());

    return response()->json([
        'message' => 'Customer status updated successfully.',
        'customer' => $customer,
    ]);
}
}
