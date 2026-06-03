<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TshirtImage;
use App\Models\Color;
use Illuminate\Support\Facades\DB;

class ProductShow extends Component
{
    public $tshirt;
    public $selectedColor;
    public $selectedSize = 'M';
    
    // 1. Declarar a propriedade da quantidade para o Livewire a monitorizar
    public $qty = 1; 

    public function mount($id)
    {
        $this->tshirt = TshirtImage::findOrFail($id);
        $this->selectedColor = Color::first()?->code ?? 'ffffff';
    }

    public function render()
    {
        $priceRules = DB::table('prices')->first();

        return view('catalog.product-show', [
            'colors' => Color::all(),
            'priceRules' => $priceRules,
        ])->layout('components.layouts.app');
    }
}