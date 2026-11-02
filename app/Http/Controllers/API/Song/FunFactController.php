<?php

namespace App\Http\Controllers\API\Song;

use App\Http\Controllers\Controller;
use App\Models\FunFact;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FunFactController extends Controller
{
    use ApiResponse;

    public function allFunFact()
    {
        $data = FunFact::with('language')->latest()->get();

        return $this->success('Data get successfully',$data);
    }

    public function funFactDetails($id)
    {
        $data = FunFact::find($id);

        if (!$data) {
            return $this->error('Data not found');
        }

        return $this->success('Data get successfully',$data);
    }
}
