<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CustomerFormRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CustomerController extends Controller implements HasMiddleware
{
    use \App\Traits\UserPhotoFileStorage;

    public static function middleware(): array
    {
        return [
            new Middleware('can:viewAny,App\Models\Customer', only: ['index']),
            new Middleware('can:create,App\Models\Customer', only: ['create', 'store']),
            new Middleware('can:view,customer', only: ['show']),
            new Middleware('can:update,customer', only: ['edit', 'update']),
            new Middleware('can:delete,customer', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of customers
     */
    public function index(Request $request): View
    {
        $customersQuery = Customer::with('user')
            ->orderBy('id');

        $filterByName = $request->query('name');
        $filterByNif = $request->query('nif');

        if ($filterByName) {
            $customersQuery->whereHas('user', function ($query) use ($filterByName) {
                $query->where('name', 'like', "%$filterByName%");
            });
        }

        if ($filterByNif) {
            $customersQuery->where('nif', 'like', "%$filterByNif%");
        }

        $customers = $customersQuery->paginate(20)->withQueryString();

        return view('customers.index', compact('customers', 'filterByName', 'filterByNif'));
    }

    /**
     * Show the form for creating a new customer
     */
    public function create(): View
    {
        $newCustomer = new Customer();
        return view('customers.create')->with('customer', $newCustomer);
    }

    /**
     * Store a newly created customer
     */
    public function store(CustomerFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        // Create User first
        $newUser = new User();
        $newUser->user_type = 'C'; // Customer
        $newUser->name = $validatedData['name'];
        $newUser->email = $validatedData['email'];
        $newUser->gender = $validatedData['gender'];
        $newUser->blocked = false;
        $newUser->password = bcrypt('123'); // Default password
        $newUser->save();

        // Create Customer with same ID
        $newCustomer = new Customer();
        $newCustomer->id = $newUser->id;
        $newCustomer->nif = $validatedData['nif'] ?? null;
        $newCustomer->address = $validatedData['address'] ?? null;
        $newCustomer->default_payment_type = $validatedData['default_payment_type'] ?? null;
        $newCustomer->default_payment_ref = $validatedData['default_payment_ref'] ?? null;
        $newCustomer->save();

        // Store photo if uploaded
        if ($request->hasFile('photo_file')) {
            $this->storeUserPhoto($request->photo_file, $newUser);
        }

        // Send email verification notification
        $newUser->sendEmailVerificationNotification();

        $url = route('customers.show', ['customer' => $newCustomer]);
        $htmlMessage = "Customer <a href='$url'><u>{$newUser->name}</u></a> has been created successfully!";

        return redirect()->route('customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified customer
     */
    public function show(Customer $customer): View
    {
        $customer->load('user');
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer
     */
    public function edit(Customer $customer): View
    {
        $customer->load('user');
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer
     */
    public function update(CustomerFormRequest $request, Customer $customer): RedirectResponse
    {
        $validatedData = $request->validated();

        // Update User
        $user = $customer->user;
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->gender = $validatedData['gender'];
        $user->save();

        // Update Customer
        $customer->nif = $validatedData['nif'] ?? null;
        $customer->address = $validatedData['address'] ?? null;
        $customer->default_payment_type = $validatedData['default_payment_type'] ?? null;
        $customer->default_payment_ref = $validatedData['default_payment_ref'] ?? null;
        $customer->save();

        // Handle photo update
        if ($request->hasFile('photo_file')) {
            $this->deleteUserPhoto($user);
            $this->storeUserPhoto($request->photo_file, $user);
        }

        $url = route('customers.show', ['customer' => $customer]);
        $htmlMessage = "Customer <a href='$url'><u>{$user->name}</u></a> has been updated successfully!";

        return redirect()->route('customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified customer (soft delete)
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        try {
            $user = $customer->user;
            $url = route('customers.show', ['customer' => $customer]);
            $fileName = $user->photo_url;

            // Soft delete customer and user
            $customer->delete();
            $user->delete();
            $this->deletePhotoFile($fileName);

            $alertType = 'success';
            $alertMsg = "Customer {$user->name} has been deleted successfully!";

            return redirect()->route('customers.index')
                ->with('alert-type', $alertType)
                ->with('alert-msg', $alertMsg);
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the customer!";

            return redirect()->back()
                ->with('alert-type', $alertType)
                ->with('alert-msg', $alertMsg);
        }
    }

    /**
     * Force delete a customer (permanent)
     */
    public function forceDelete(int|string $id): RedirectResponse
    {
        $customer = Customer::withTrashed()->findOrFail($id);
        $user = User::withTrashed()->findOrFail($customer->id);
        $fileName = $user->photo_url;

        // Force delete
        $customer->forceDelete();
        $user->forceDelete();
        $this->deletePhotoFile($fileName);

        return redirect()->route('customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Customer has been permanently deleted!");
    }

    /**
     * Restore a soft-deleted customer
     */
    public function restore(int|string $id): RedirectResponse
    {
        $customer = Customer::withTrashed()->findOrFail($id);
        $user = User::withTrashed()->findOrFail($customer->id);

        $customer->restore();
        $user->restore();

        return redirect()->route('customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Customer has been restored!");
    }
    /**
     * Toggle block status of a customer's user account
     */
    public function toggleBlock(Customer $customer): RedirectResponse
    {
        // O middleware 'can' ou a vossa policy tratará da segurança se necessário
        $user = $customer->user;
        $user->blocked = !$user->blocked;
        $user->save();

        $status = $user->blocked ? 'blocked' : 'unblocked';

        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Customer {$user->name} has been successfully {$status}!");
    }
}
