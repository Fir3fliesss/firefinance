<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = User::where('role_name', 'client')->get();
        $services = Service::all();

        if ($clients->isEmpty() || $services->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'paid', 'active', 'cancelled'];
        
        for ($i = 0; $i < 20; $i++) {
            $client = $clients->random();
            $status = $statuses[array_rand($statuses)];
            $createdAt = now()->subDays(rand(1, 30))->subHours(rand(1, 24));
            
            $order = Order::create([
                'user_id' => $client->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => 0, 
                'status' => $status,
                'notes' => rand(0, 1) ? 'Tolong diproses cepat ya' : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $selectedServices = $services->random(rand(1, 3));
            $totalAmount = 0;

            foreach ($selectedServices as $service) {
                $totalAmount += $service->price;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'service_id' => $service->id,
                    'quantity' => 1,
                    'unit_price' => $service->price,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
            
            $order->update(['total_amount' => $totalAmount]);

            $invoiceStatus = match($status) {
                'paid', 'active' => 'paid',
                'cancelled' => 'cancelled',
                default => 'unpaid'
            };
            
            Invoice::create([
                'order_id' => $order->id,
                'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                'issue_date' => $createdAt->toDateString(),
                'due_date' => $createdAt->addDays(7)->toDateString(),
                'status' => $invoiceStatus,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
