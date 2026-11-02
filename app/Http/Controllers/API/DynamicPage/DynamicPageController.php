<?php

namespace App\Http\Controllers\API\DynamicPage;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DynamicPageController extends Controller
{
    use ApiResponse;

    public function page($id)
    {
        $data = DynamicPage::where('status', 'Active')->where('id', $id)->first();
        if ($data) {
            return $this->ok('Data get Successfully!',$data, 200);
        }
        return $this->error("Data not found", 500);
    }
}
