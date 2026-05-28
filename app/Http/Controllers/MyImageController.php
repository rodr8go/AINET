<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TshirtImage;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MyImageController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Procura o ID do cliente com fallback seguro
        $customerId = DB::table('customers')->where('id', $user->id)->value('id') ?? $user->id;

        // Procura as imagens associadas ao cliente
        $images = TshirtImage::where('customer_id', $customerId)
            ->orderBy('id', 'desc')
            ->get();

        // Apenas devolve a view limpa
        return view('pages.my-images.index', compact('images'));
    }
}