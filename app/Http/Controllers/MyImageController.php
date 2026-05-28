<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TshirtImage;
use Illuminate\Support\Facades\DB;

class MyImageController extends Controller
{
    // Usamos o Trait oficial para fazer o upload limpo das imagens
    use \App\Traits\CourseImageFileStorage;

    public function index()
    {
        $user = Auth::user();
        $customerId = DB::table('customers')->where('id', $user->id)->value('id') ?? $user->id;

        $images = TshirtImage::where('customer_id', $customerId)
            ->orderBy('id', 'desc')
            ->get();

        return view('pages.my-images.index', compact('images'));
    }

    /**
     * 1. Mostra a página do formulário de upload
     */
    public function create()
    {
        return view('pages.my-images.create');
    }

    /**
     * 2. Processa o envio da imagem e guarda na Base de Dados
     */
    public function store(Request $request)
    {
        // Validação básica do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'image_file' => 'required|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        $user = Auth::user();
        $customerId = DB::table('customers')->where('id', $user->id)->value('id') ?? $user->id;

        // Se o ficheiro veio direito, guarda-o fisicamente no servidor usando o Trait
        if ($request->hasFile('image_file')) {
            $filename = $this->storeImage($request->file('image_file'), 'tshirt_images');

            // Insere o registo na tabela tshirt_images
            TshirtImage::create([
                'customer_id' => $customerId,
                'name' => $request->name,
                'image_url' => $filename, // Nome único gerado pelo Trait
                'extra_info' => 'Imagem enviada pelo cliente através do painel privado.',
            ]);
        }

        // Redireciona de volta para a lista com uma mensagem de sucesso
        return redirect()->route('my-images.index')->with('success', 'Imagem enviada com sucesso!');
    }

    /**
     * 3. Permite ao cliente apagar a sua estampa
     */
    public function destroy($id)
    {
        $image = TshirtImage::findOrFail($id);

        // Apaga o ficheiro físico do disco usando o Trait
        $this->deleteImage($image->image_url, 'tshirt_images');

        // Apaga do banco de dados
        $image->delete();

        return redirect()->route('my-images.index')->with('success', 'Imagem eliminada com sucesso!');
    }
}