<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryData extends Model
{
    protected $fillable = [
        'id','delivery_id','cash_record','credit_given','credit_record','balance_credit',
        'cancelled','shortage','damage','expiry','upi_record','cheque_record','invoice',
        'cheque_cleared','cheque_balance','total_collection','balance_collection','discount','cgst','sgst'
    ];

    public function delivery(){
        
        return $this->hasOne(Delivery::class,'id','delivery_id');
    }
}