<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TshirtImage;
use App\Models\Color;

class ProductShow extends Component
{
    public TshirtImage $tshirt;
    public $selectedColor;
    public $selectedSize = 'M';

    public function mount($id)
    {
        $this->tshirt = TshirtImage::findOrFail($id);

        // Arranca com a cor padrão (a primeira que existir na BD)
        $this->selectedColor = Color::first()?->code ?? 'ffffff';
    }

    public function render()
    {
        return view('catalog.product-show', [
            'colors' => Color::all(),
        ])->layout('components.layouts.app');
    }
}