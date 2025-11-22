<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function createReview(ReviewRequest $request){
        // data yang kevalidate
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        // create query
        $review = Review::create($validatedData);
        // return json
        return response()->json([
            'message' => "Review berhasil dibuat",
            'review' => $review
        ],201);
    }
    public function deleteReview(Request $request, string $id){
        // find reviewnya
        $review = Review::findOrFail($id);
        // delete reviewnya
        $review->delete();
        // kasih response
        return response()->json([
            'message' => 'Review berhasil dihapus',
            'review' => $review
        ],201);

    }
    public function getAllReview(Request $request){
        // pertama cek dulu apakah dia mau all,show, atau hide.
        if($request->query('status') == 'all' && $request->user()->is_admin){
            $review = Review::all();
            return response()->json([
            "message" => "Review show dan hide ditemukan",
            "Products" => $review
        ],200);

        }
        elseif($request->query('status') == 'show'){
            $review = Review::where('state','show')->get();
            return response()->json([
            "message" => "Review dengan status show ditemukan",
            "Products" => $review
        ],200);

        }
        elseif($request->query('status') == 'hide' && $request->user()->is_admin){
            $review = Review::where('state','hide')->get();
            return response()->json([
            "message" => "Review dengan status hide ditemukan",
            "Products" => $review
        ],200);
        }
        else{
        return response()->json([
            'message' => 'Kesalahan di Request'
        ],400);
        }

    }
    public function getSpecificReview(Request $request, string $id){
        // dapetin review yang specific terus return
            $review = Review::findOrFail($id);
            return response()->json([
            "message" => "Review ditemukan",
            "Products" => $review
        ],200);
    }
    public function changeStateReview(Request $request, string $id){
            $newState = $request->state;
            $review = Review::findOrFail($id);
            $review->update([
            'state' => $request->state
        ]);
            return response()->json([
            "message" => "State diubah",
            "Products" => $newState
        ],201);


        
    }
    public function homeReview(){
            $review = Review::with('user:id,name') // Ambil id dan name saja biar hemat
                        ->where('state', 'show')
                        ->get();
            return response()->json([
            "message" => "Review dengan status show ditemukan",
            "Products" => $review
        ],200);
    }
}
