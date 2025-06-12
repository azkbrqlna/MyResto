<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Foods;
use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class DetailPage extends Component
{
    public $categories;
    public $food;
    public $matchedCategory;
    public $title = "Favorite";

    public function mount(Foods $foods, $id){
        
        $this->categories = Category::all();
        $this->food = $foods->getFoodDetails($id)->first();

        if(empty($this->food)){
            abort(404);
        }

        $this->matchedCategory = collect($this->categories)->firstWhere('id', $this->food->categories_id);
        
    }

    public function addToCart(){
        $cartItems = session('cart_items', []);
        $existingItemIndex = collect($cartItems)->search(fn($item) => $item['id'] === $this->food->id);

        if($existingItemIndex !== false){
            $cartItems[$existingItemIndex]['quantity'] += 1;
        }else{
            $cartItems[] = array_merge(
                (array)$this->food,
                ['quantity' => 1, 'selected' => true]
            );
        }

        session(['cart_items' => $cartItems]);
        session(['has_unpaid_transaction' => false]);

        $this->dispatch('toast' , data : [
            'message1' => 'Added to cart',
            'message2' => $this->food->name,
            'type'=> 'success'
        ]);
    }

    public function orderNow() {
        $this->addToCart();
        return redirect()->route('payment.checkout');
    }

    #[Layout('components.layouts.page')]
    public function render()
    {
        return view('product.details');
    }
}
