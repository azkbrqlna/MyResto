<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Foods;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AllFoodPage extends Component
{
    // use CategoryFilterTrait;

    public $categories;
    public $selectedCategories = [];
    public $items;
    public $title = "All Food";

    public function mount(Foods $foods) {
        $this->categories = Category::all();
        $this->items = $foods->getAllFoods();
    }

    #[Layout('components.layouts.page')]

    public function render()
    {
        $filteredProducts = $this->getFilteredItems();
        return view('product.all-food',[
                'filteredProducts' => $filteredProducts
        ]);
        // return view('livewire.pages.all-food-page');
    }
}
