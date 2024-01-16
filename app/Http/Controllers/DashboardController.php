<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Product;
use App\Models\PrimaryLabel;
use App\Models\LabelType;
use Auth;

class DashboardController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index() {
    $greenLabel = LabelType::where('name','=','green')->first();
    $whiteLabel = LabelType::where('name','=','white')->first();
    $mediumLabel = LabelType::where('name','=','medium')->first();
    $smallLabel = LabelType::where('name','=','small')->first();
    if (!(Auth::user()->role_id)) {
      //$whereCondition = where('user_id', $userID);
    }
    $productCount = Product::count(); 
    // $allPrimaryLabels = PrimaryLabel::get();
    // echo $allPrimaryLabels->groupBy('label_type')->map->count();
    // $this->pr($allPrimaryLabels->toArray());
    // exit;
    $green = PrimaryLabel::where('label_type',$greenLabel->id)->count();
    $white = PrimaryLabel::where('label_type',$whiteLabel->id)->count();
    $medium = PrimaryLabel::where('label_type',$mediumLabel->id)->count();
    $small = PrimaryLabel::where('label_type',$smallLabel->id)->count();
    $totalCount = $green + $white + $medium + $small;;
    return view('dashboard.index', compact('productCount','green','white','medium','small','totalCount'));
  }

}

