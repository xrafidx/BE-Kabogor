<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function createReview(ReviewRequest $request){
        // data yang kevalidate
        $validatedData = $request->validated();

    }
    public function deleteReview(Request $request, string $id){

    }
    public function getAllReview(Request $request){

    }
    public function getSpecificReview(Request $request, string $id){

    }
    public function changeStateReview(Request $request, string $id){
        
    }
}
