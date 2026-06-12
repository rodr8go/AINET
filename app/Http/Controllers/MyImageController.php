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

        return view('my-images.index', compact('images'));
    }

    /**
     * 1. Mostra a página do formulário de upload
     */
    public function create()
    {
        return view('my-images.create');
    }

    /**
     * 2. Processa o envio da imagem e guarda na Base de Dados
     */
    /**
     * Processa o envio da imagem para a pasta PRIVADA
     *//**
     * Processa o envio da imagem e força a gravação no caminho privado real
     */
    public function store(Request $request)
    {
        // 1. Validação do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'image_file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $customerId = \Illuminate\Support\Facades\DB::table('customers')->where('id', $user->id)->value('id') ?? $user->id;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            
            // 🎯 GERAR NOME ÚNICO (Para evitar ficheiros duplicados com o mesmo nome)
            $filename = $customerId . '_' . time() . '.' . $file->getClientOriginalExtension();

            // 📁 CAMINHO REAL ABSOLUTO: storage/app/private/tshirt_images_private
            $destinationPath = storage_path('app/private/tshirt_images_private');

            // Se a pasta física ainda não existir por algum motivo, o PHP cria-a na hora
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // 💾 Mover o ficheiro diretamente para a pasta certa usando o PHP nativo (à prova de falhas do Trait)
            $file->move($destinationPath, $filename);

            // 📝 Guardar o registo na Base de Dados com o nome do ficheiro gerado
            TshirtImage::create([
                'customer_id' => $customerId,
                'name' => $request->name,
                'image_url' => $filename,
                'extra_info' => 'Imagem privada enviada pelo cliente.',
            ]);
        }

        return redirect()->route('my-images.index')->with('success', 'Imagem guardada com sucesso!');    
}

    /**
     * Apaga a imagem da pasta PRIVADA
     */
    public function destroy($id)
    {
        $image = TshirtImage::findOrFail($id);

        // 🎯 CORREÇÃO: Apaga da pasta certa
        $this->deleteImage($image->image_url, 'tshirt_images_private');

        $image->delete();

        return redirect()->route('my-images.index')->with('success', 'Imagem eliminada.');
    }

public function showImage($id)
    {
        // 1. Procura a imagem pelo ID numérico
        $tshirtImage = TshirtImage::findOrFail($id);

        // 2. Segurança: Garante que o cliente logado é o dono desta imagem
        $user = Auth::user();
        $customerId = \Illuminate\Support\Facades\DB::table('customers')->where('id', $user->id)->value('id') ?? $user->id;
        
        if ($tshirtImage->customer_id !== $customerId) {
            abort(403, 'Não tem autorização para ver esta imagem.');
        }

        // 3. Caminho absoluto para a pasta do teu print privado
        $path = storage_path('app/private/tshirt_images_private/' . $tshirtImage->image_url);

        // 4. Se o ficheiro existir, envia-o para o navegador desenhar no <img>
        if (file_exists($path)) {
            return response()->file($path);
        }

        abort(404, 'Ficheiro não encontrado no disco privado.');
    }
}