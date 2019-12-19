<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Userproduct;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('search');
    }
    public function searchinput(Request $request)
    {

        $request->validate([
            'query' => 'required|max:60',
        ]);
        $query = $request->input('query');
        $searchterm = str_replace('-', ' ', $query);
        $searchterm1 = preg_replace('/[^A-Za-z\- ]/', '', $searchterm);
        $searchResults = Userproduct::search($searchterm1)->where('delete_status', 0)->where('check_public', 1)->where('check_product_ban', 0)->paginate(2);
        return view('search', compact('searchResults', 'searchterm'));
    }
    public function autocomplete(Request $request)
    {
        // check if ajax request is coming or not
        if ($request->ajax()) {
            $query = $request->input('query');
            $searchterm = str_replace('-', ' ', $query);
            $searchterm = preg_replace('/[^A-Za-z0-9\- ]/', '', $searchterm);
            // select country name from database
            $data = Userproduct::search($searchterm)->where('delete_status', 0)->where('check_public', 1)->where('check_product_ban', 0)->paginate(5);
            // declare an empty array for output
            $output = '';
            // if searched countries count is larager than zero
            if (count($data) > 0) {
                // concatenate output to the array
                
                $output = '<ul class="suggestions shadow-lg  bg-white rounded" style="display:block; position:absolute; left: 0%;
                top: 100%;">';
      
                // loop through the result array
                $i = 0;
                foreach ($data as $row) {
                    // concatenate output to the array
                    $s=$row->title;
                    $title = str_replace(' ', '+', $s);
                    $route=route('search','query='.$title);
                    $output .= '<li id="searchlink" ><a href=" '.$route.'">'.$row->title.' by '.$row->author.'</a></li>
                    '; 
                    if ($i++== 1) { break; }
                }
                // end of output
                $output .= '</ul>';
            } else {
                // if there's no matching results according to the input
                $output .= ' ';
            }
            // return output result array
            return $output;
        }
        $query = $request->input('term');
        $searchterm = str_replace('-', ' ', $query);
        $searchterm = preg_replace('/[^A-Za-z0-9\- ]/', '', $searchterm);
        $result = Userproduct::search($searchterm)->where('delete_status', 0)->where('check_public', 1)->where('check_product_ban', 0)->get();
        dd($data);
        return response()->json($result);
    }
}
