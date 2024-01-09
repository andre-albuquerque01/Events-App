<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;

class SaveFile
{
    public function saveImagem($imagem)
    {
        $newNameImage = date('H_i_s-d_m_Y.') . $imagem->getClientOriginalExtension();
        Storage::disk("public")->put('img/' . $newNameImage, file_get_contents($imagem));
        return $newNameImage;
    }
}
