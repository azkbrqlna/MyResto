<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Session;
use Livewire\Attributes\Layout;

class CartPage extends Component
{
    // use CartManagement;

    public $foods;
    public $title = "All Foods";
    public bool $selectAll = true;
    public $selectedItems = [];

    #[Session(key: 'cart_items')]
    public $cartItems = [];
    #[Session(key: 'has_unpaid_transaction')]
    public $has_unpaid_transaction;

    public function mount()
    {
        $this->updateSelectedItems();
    }

    public function updateSelectAll() {
        foreach ($this->cartItems as $item) {
            $item['selected'] = $this->selectAll;
        }

        $this->updateSelectedItems();
    }

    public function updateSelectedItems(){
        $this->selectedItems = collect($this->cartItems)->filter(fn($item) => $item['selected'])->toArray();

        $this->selectAll = count($this->selectedItems) === count($this->cartItems);

        session(['has_unpaid_transaction' => false]);
    }

    public function deletedSelected(){
        $this->cartItems = collect($this->cartItems)->filter(fn($item) => !$item['selected'])->toArray();

        $selectedIds = collect($this->selectedItems)->map(fn($item) => $item['id'])->toArray();

        $cartItemIds = collect(session('cart_items'), [])->map(fn($item) => $item['id'])->toArray();
        $cartItemIds = array_diff($cartItemIds, $selectedIds);

        session(['cart_items' => $cartItemIds]);

        $this->selectedItems = [];
    }   

    public function checkout(){
        if(empty($this->selectedItems)){
            $this->addError('selectedItems','Please select at least one item');
            return;
        }

        session(['cart_items' => $this->cartItems]);
        
        return $this->redirect('/checkout', navigate:true);
    }

    #[Layout('components.layouts.page')]
    public function render()
    {
        return view('payment.cart');
    }
}
