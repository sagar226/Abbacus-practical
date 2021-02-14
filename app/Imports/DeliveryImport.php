<?php

namespace App\Imports;

use App\Delivery;
use App\DeliveryData;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Facades\Invoice;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        
        $data=$rows->toArray();
        $count=0;
        $result=[];
        $result['total_row'] = count($data)-1;
        $current = new Carbon();
        $result['failed']=[];
        foreach ($rows as $key=>$row) 
        {
            if($key == 0 ) continue;
            try{
                $date=Carbon::parse($row[0])->format('Y-m-d');

                $delivery= Delivery::create([
                'date' => $date,
                'delivery_note_number' => $row[1],
                'beat_name' => $row[2],
                'uid' => $row[3],
                'shop_name' => $row[4],
                'invoice_number' => $row[5],
                'net_receivable' => $row[6]
            ]);
           $deliveryData= DeliveryData::create([
                'delivery_id' => $delivery->id,
                'cash_record' => is_numeric($row[7]) ? $row[7] : 0,
                'credit_given' => is_numeric($row[8]) ? $row[8] : 0,
                'credit_record' =>is_numeric($row[9]) ? $row[9] : 0,
                'balance_credit' => is_numeric($row[10]) ? $row[10] : 0 ,
                'cancelled' => is_numeric($row[11]) ? $row[11] : 0 ,
                'shortage' => is_numeric($row[12]) ? $row[12] : 0 ,
                'damage' => is_numeric($row[13]) ? $row[13] : 0 ,
                'expiry' => is_numeric($row[14]) ? $row[14] : 0 ,
                'upi_record' => is_numeric($row[15]) ? $row[15] : 0 ,
                'cheque_record' => is_numeric($row[16]) ? $row[16] : 0 ,
                'cheque_cleared' => is_numeric($row[17]) ? $row[17] : 0 ,
                'cheque_balance' =>is_numeric($row[18]) ? $row[18] : 0 ,
                'total_collection' => is_numeric($row[19]) ? $row[19] : 0 ,
                'balance_collection' => is_numeric($row[20]) ? $row[20] : 0 ,
            ]);
            $this->createInvoice($delivery,$deliveryData);
            $count++;
           }catch(Exception $e){
                $result['failed'][]=[
                    'delivery_note_number' => $row[1],
                    'beat_name' => $row[2],
                    'fail_reason' => $e->getMessage()
                ];

           }
        }
        $result['success'] = $count;
      
    }
    public function createInvoice($delivery,$deliveryData){

        try{  
        $customer = new Buyer([
            'name'          => $delivery->shop_name,
            'custom_fields' => [
                'Delivery Note Number' => $delivery->delivery_note_number,
                'Beat Name' => $delivery->beat_name,
                'Invoice Number' => $delivery->invoice_number,
                'uid' => $delivery->uid
            ]
        ]);
   
        
        $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);
        $date=Carbon::parse($delivery->date)->format('Y-m-d');
        $date = new \DateTime($date);


        $dueDateTime = Carbon::createFromFormat('Y-m-d', $delivery->date);   


        $items = [
            (new InvoiceItem())->title($delivery->beat_name)->pricePerUnit(47.79)->quantity(2)->discount(10)
        ];

        $invoice = Invoice::make()
            ->buyer($customer)
            ->series('BIG')
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->dateFormat('Y-m-d')
            ->date($dueDateTime)
            ->currencyCode('INR')
            ->currencySymbol('₹')
            ->filename($delivery->shop_name)
            ->addItems($items)
            ->save('public');
        $link = $invoice->url();
        dd($link);
          }catch(Exception $e){
            dd($e);
          } 

    }   
}
