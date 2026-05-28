<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait CourseImageFileStorage
{
    /**
     * Guarda uma imagem no disco público.
     */
    public function storeImage(UploadedFile $file, string $folder = 'tshirt_images'): string
    {
        // Gera um nome único para o ficheiro baseado no timestamp e id
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Guarda o ficheiro na pasta especificada dentro do disco public
        $file->storeAs($folder, $filename, 'public');

        return $filename;
    }

    /**
     * Apaga uma imagem existente do disco público.
     */
    public function deleteImage(?string $filename, string $folder = 'tshirt_images'): bool
    {
        if ($filename && Storage::disk('public')->exists("{$folder}/{$filename}")) {
            return Storage::disk('public')->delete("{$folder}/{$filename}");
        }

        return false;
    }
}