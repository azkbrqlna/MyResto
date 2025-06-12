<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Foods;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class FavoritePage extends Component
{
    // use CategoryFilterTrait;

    public $categories;
    public $selectedCategories = [];
    public $items;
    public $title =  'Favorite';

    public function mount(Foods $foods){
        $this->categories = Category::all();
        $this->items = $foods->getFavoriteFood();
    }

    #[Layout('components.layouts.page')]
    public function render()
    {
        $filteredProducts = $this->getFilteredItems();
        // return view('livewire.pages.favorite-page');
        return view('product.favorite',[
            'filteredProducts' => $filteredProducts
        ]);
    }
}
