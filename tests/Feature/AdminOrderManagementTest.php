<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_use_customer_ordering_flow(): void
    {
        $admin = $this->createUser('admin');

        $this->actingAs($admin)->get('/cart')->assertForbidden();
        $this->actingAs($admin)->get(route('orders.checkout'))->assertForbidden();
        $this->actingAs($admin)->post(route('orders.store'), [
            'delivery_address' => 'Cotonou',
        ])->assertForbidden();
        $this->actingAs($admin)->get(route('orders.index'))->assertForbidden();
    }

    public function test_admin_can_manage_orders_and_see_users(): void
    {
        $admin = $this->createUser('admin');
        $customer = $this->createUser('user', 'Client Test');
        $order = $this->createOrder($customer);

        $this->actingAs($admin)
            ->get(route('admin.orders.index'))
            ->assertOk()
            ->assertSee('Client Test');

        $this->actingAs($admin)
            ->get(route('admin.orders.show', $order))
            ->assertOk()
            ->assertSee('Poulet rôti')
            ->assertSee('Suivi de livraison')
            ->assertSee('En attente de confirmation');

        $this->actingAs($admin)
            ->patch(route('admin.orders.confirm', $order))
            ->assertRedirect();

        $this->assertSame('confirmed', $order->fresh()->status);
        $this->assertNotNull($order->fresh()->confirmed_at);

        $this->actingAs($admin)
            ->patch(route('admin.orders.delivery', $order), [
                'driver_name' => 'Koffi Livreur',
                'driver_phone' => '0102030405',
                'estimated_delivery_at' => now()->addHour()->format('Y-m-d\TH:i'),
                'delivery_notes' => 'Appeler à l’arrivée',
            ])
            ->assertRedirect();

        $this->assertSame('Koffi Livreur', $order->fresh()->driver_name);

        $this->actingAs($admin)
            ->patch(route('admin.orders.status', $order), ['status' => 'ready'])
            ->assertRedirect();

        $this->assertSame('ready', $order->fresh()->status);
        $this->assertNotNull($order->fresh()->ready_at);

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Client Test');
    }

    public function test_payment_does_not_confirm_order_without_admin(): void
    {
        $customer = $this->createUser('user', 'Client Test');
        $order = $this->createOrder($customer);

        $this->actingAs($customer)
            ->post(route('paiements.store', $order), [
                'telephone' => '0102030405',
                'operateur' => 'mtn',
            ])
            ->assertRedirect(route('paiements.success', $order));

        $this->assertSame('pending', $order->fresh()->status);
        $this->assertDatabaseHas('paiements', [
            'order_id' => $order->id,
            'statut' => 'payé',
        ]);
    }

    public function test_customer_cannot_access_another_customers_order_or_payment(): void
    {
        $customer = $this->createUser('user', 'Client Un');
        $other = $this->createUser('user', 'Client Deux');
        $order = $this->createOrder($other);

        $this->actingAs($customer)->get(route('orders.show', $order))->assertForbidden();
        $this->actingAs($customer)->get(route('paiements.show', $order))->assertForbidden();
        $this->actingAs($customer)->get(route('paiements.success', $order))->assertForbidden();
    }

    public function test_registration_creates_a_customer_account(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Nouveau Client',
            'email' => 'nouveau@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'nouveau@example.com',
            'role' => 'user',
        ]);
    }

    private function createUser(string $role, ?string $name = null): User
    {
        return User::create([
            'name' => $name ?? ($role === 'admin' ? 'Admin Test' : 'Client Test'),
            'email' => ($role === 'admin' ? 'admin-test' : 'client-'.uniqid()).'@example.com',
            'password' => bcrypt('password'),
            'role' => $role,
        ]);
    }

    private function createOrder(User $customer): Order
    {
        $category = Category::create([
            'name' => 'Plats',
            'slug' => 'plats-'.uniqid(),
        ]);

        $item = MenuItem::create([
            'category_id' => $category->id,
            'name' => 'Poulet rôti',
            'slug' => 'poulet-'.uniqid(),
            'price' => 7500,
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'status' => 'pending',
            'total_amount' => 7500,
            'delivery_address' => 'Cotonou, Bénin',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $item->id,
            'quantity' => 1,
            'unit_price' => 7500,
        ]);

        return $order;
    }
}
