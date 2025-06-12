<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Foods;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Str;
use Livewire\Attributes\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class CheckoutPage extends Component
{
    // use CartManagement;
    public $name;
    public $phone;
    #[Session(key:'table_number')]
    public $tableNumber;
    #[Session(key : 'tax')]
    public $tax;
    #[Session(key : 'has_unpaid_transaction')]
    public $hasUnpaidTransaction;
    #[Session(key : 'cart_items')]
    public $cartItems = [];

    public $title = "All Foods";

    public $total;
    public $subTotal;

    public $paymentToken;

    #[On('saved-user-info')]
    public function mount(){
        $this->name = session('name');
        $this->phone = session('phone');
        if (empty($this->cartItems)){
            return redirect()->route('product.cart');
        }

        $this->paymentToken = Str::random(32);
        session(['payment_token' => $this->paymentToken]);

        $this->updateTotals();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('payment.checkout');
    }
}
