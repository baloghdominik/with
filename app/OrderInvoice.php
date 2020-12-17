<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderInvoice extends Model
{
    public $table = "order_invoice";
    protected $fillable = [
        'order_id', 
        'restaurant_id', 
        'invoice_is_company', 
        'invoice_name',
        'invoice_zipcode',
        'invoice_city',
        'invoice_address',
        'invoice_tax_number'
    ];

    public function order(){
        return $this->belongsTo('App\Order','order_id','id');
    }
}