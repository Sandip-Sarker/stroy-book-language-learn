<?php

namespace App\Http\Controllers\API\Song;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\SongCategory;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    use ApiResponse;

    public function language()
    {
        $data = Language::latest()->get();
        return $this->success('Data get successfully', $data, 200);
    }

}
