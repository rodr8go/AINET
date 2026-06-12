<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TshirtImage;
use App\Models\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyImagePreview extends Component
{
    public $tshirt;
    public $selectedColor;
    public $selectedSize = 'M';
    public $qty = 1;

    public function mount($id)
    {
        $tshirt = TshirtImage::findOrFail($id);

        // Segurança: só o dono pode ver
        $user = Auth::user();
        $customerId = DB::table('customers')->where('id', $user->id)->value('id') ?? $user->id;

        if ($tshirt->customer_id !== $customerId) {
            abort(403);
        }

        $this->tshirt = $tshirt;
        $this->selectedColor = Color::first()?->code ?? 'ffffff';
    }

public function render()
{
    $priceRules = DB::table('prices')->first();

    return view('my-images.my-image-preview', [  // <-- caminho correto
        'colors'     => Color::all(),
        'priceRules' => $priceRules,
    ])->layout('components.layouts.app');
}
}