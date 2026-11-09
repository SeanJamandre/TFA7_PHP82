<?php
namespace App\Http\Controllers;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
class CustomerController extends Controller {
 public function index() { return view('customers.index',['customers'=>Customer::latest()->get()]); }
 public function create() { return view('customers.form',['customer'=>new Customer]); }
 public function store(CustomerRequest $request) { Customer::create($request->validated()); return to_route('customers.index')->with('success','Customer created.'); }
 public function edit(Customer $customer) { return view('customers.form',compact('customer')); }
 public function update(CustomerRequest $request, Customer $customer) { $customer->update($request->validated()); return to_route('customers.index')->with('success','Customer updated.'); }
}
