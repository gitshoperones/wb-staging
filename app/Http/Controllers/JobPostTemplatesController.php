<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobPostTemplatesController extends Controller
{
    public function show($categoryId)
    {
        $template = Category::whereId($categoryId)->firstOrFail()->jobPostTemplates()->first();

        return response()->json($template);
    }
}
