<?php

namespace App\Http\Services;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function getCustomerZip($customerid)
    {
        $customer = Customer::where('id', '=', $customerid)->first();
        
        return $customer->zipcode;
    }

}