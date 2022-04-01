<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function sendRating(Request $request){
        $data = $request->all();
        $rating = new Rating();
        $rating->product_id = $data['product_id'];
        $rating->rating_num = $data['index'];
        $rating->save();
    }
    public function loadRating(Request $request){
        $data = $request->all();
        $rating = Rating::where('product_id', $data['product_id'])->avg('rating_num');
        $rating = round($rating);
        $output = '';  
        $output .= '<ul class="list-inline" title="average rating">';
                            for($count = 1; $count <=5; $count++){
                                if($count <= $rating){
                                $color = "color:#ffcc00";
                                }else{
                                    $color = "color:#ccc";
                                }

                            $output .= '<li title="star_rating" id="'.$data["product_id"].'-'.$count.'"
                                                    data-index="'.$count.'"
                                                    data-product_id="'.$data["product_id"].'"
                                                    data-rating="'.$rating.'" class="rating" style="cursor: pointer;
                                                    '.$color.'; font-size:30px; 
                                                    ">
                                                &#9733;    
                                                </li>';
                        }
        echo $output;
    }
}