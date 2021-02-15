<?php

namespace App\Imports;

use App\Delivery;
use App\DeliveryData;
use App\FileLog;
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
    public $uuid;
    public function __construct($uuid)
    {   
        $this->uuid=$uuid;
    
    }
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
                'discount' =>is_numeric($row[21]) ? $row[21] : 0 ,
                'cgst' => is_numeric($row[22]) ? $row[22] : 0 ,
                'sgst' => is_numeric($row[23]) ? $row[23] : 0 ,
            ]);

            $this->createInvoice($delivery,$deliveryData);
            $count++;
            
           }catch(Exception $e){
            dd($e);
            FileLog::create([

                'uuid'=>$this->uuid,
                'row_number'=>$key+1,
                'delivery_note_number'=> $row[1]
                ,'beat_name'=> $row[2],'fail_reason' => $e->getMessage()
            ]);
           }
        }

        $result['success'] = $count;
      
    }
    public function createInvoice($delivery,$deliveryData){
 
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
            (new InvoiceItem())->title("Net Receivable")->pricePerUnit($delivery->net_receivable),
            (new InvoiceItem())->title("Cash Recd")->pricePerUnit($deliveryData->cash_record),
            (new InvoiceItem())->title("Credit Given")->pricePerUnit($deliveryData->credit_given),
            (new InvoiceItem())->title("Credit Recd")->pricePerUnit($deliveryData->credit_record),
            (new InvoiceItem())->title("Balance Credit")->pricePerUnit($deliveryData->balance_credit),
            (new InvoiceItem())->title("Cancelled")->pricePerUnit($deliveryData->cancelled),
            (new InvoiceItem())->title("Shortage")->pricePerUnit($deliveryData->shortage),
            (new InvoiceItem())->title("Damage")->pricePerUnit($deliveryData->damage),
            (new InvoiceItem())->title("Expiry")->pricePerUnit($deliveryData->expiry),
            (new InvoiceItem())->title("UPI Recd")->pricePerUnit($deliveryData->upi_record),
            (new InvoiceItem())->title("Cheque Recd")->pricePerUnit($deliveryData->cheque_record),
            (new InvoiceItem())->title("Cheque Cleared")->pricePerUnit($deliveryData->cheque_cleared),
            (new InvoiceItem())->title("Cheque Balance")->pricePerUnit($deliveryData->cheque_balance),
            (new InvoiceItem())->title("Discount")->pricePerUnit($deliveryData->discount),
            (new InvoiceItem())->title("CGST%")->pricePerUnit($deliveryData->cgst),
            (new InvoiceItem())->title("SGST%")->pricePerUnit($deliveryData->sgst),
            (new InvoiceItem())->title("Total collection")->pricePerUnit($deliveryData->total_collection),
            (new InvoiceItem())->title("Balance collection")->pricePerUnit($deliveryData->balance_collection),
         
        ];
        $name=time().'_'.$delivery->shop_name;
        $invoice = Invoice::make("DELIVERY INVOICE")
            ->buyer($customer)  
            ->dateFormat('Y-m-d')
            ->date($dueDateTime)
            ->currencyCode('INR')
            ->currencySymbol('₹')
            ->filename($name)
            ->addItems($items)
            ->save('public');
            Delivery::where('id',$delivery->id)->update([
                'invoice'=> $name.'.pdf'
            ]);    
    }   
}
