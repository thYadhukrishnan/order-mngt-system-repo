<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendOrderDetails implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $customer = Customer::find($this->data->customer_id);

        Mail::raw('Total Amount :'.$this->data->total_amount, function ($message) use ($customer){
            $message->to($customer->email)
                    ->subject('Order Confirmed');
        });

        \Log::info($this->data->total_amount);
    }
}
