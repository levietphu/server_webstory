<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Auth;

class ReviewController extends Controller
{
    public function review(Request $req)
    {
        if ($req->ajax()) {

            $review_user = Review::where('id_truyen',$req->id_truyen)->where('id_user',Auth::id())->get();
            if ($review_user->count()<1) {
                $new_review = new Review;
                $new_review->id_truyen = $req->id_truyen;
                $new_review->id_user = Auth::id();
                $new_review->score = $req->score;
                $new_review->save();

                $review = Review::where('id_truyen',$req->id_truyen)->get();
                $count_review = count($review);
                $check_score=0;
                if ($count_review!=0) {
                    foreach ($review as $value) {
                    $check_score += $value->score;
                    }
                    $score=round($check_score/$count_review);
                }else{
                    $score=0;
                };
            }else{
                $review = Review::where('id_truyen',$req->id_truyen)->get();
                $count_review = count($review);
                $check_score=0;
                if ($count_review!=0) {
                    foreach ($review as $value) {
                    $check_score += $value->score;
                    }
                    $score=round($check_score/$count_review);
                }else{
                    $score=0;
                };
            }
                return view('frontend.pages.review',compact('score','count_review','review_user'))->render();
             
        }
        
    }
}
