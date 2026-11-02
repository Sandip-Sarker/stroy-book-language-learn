<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Service;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    use ApiResponse;

    public function faq()
    {
        $faqs = Faq::where('status', 'Active')->latest()->get();
        return $this->success('Faq get successfully', $faqs, 200);

    }

    public function faqShow($id)
    {
        $data = Faq::where('status', 'Active')->find($id);
        return $this->success('Faq get successfully', $data, 200);
    }
}
