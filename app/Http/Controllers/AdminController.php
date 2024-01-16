<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserProfile;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use PDF;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Password;
use App\Notifications\OnBoardUser;

class AdminController extends Controller {
  public function index(Request $request) {
    $users = User::where('id','!=',Auth()->id())
              ->whereNull('role_id')
              ->get();
    $data = compact('users');
    return view('admin.index')->with($data);
  }
  public function create() {
    return view('admin.create');
  }

  public function store(Request $request) {
    $validator = Validator::make($request->all(),[
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'phone' => ['required', 'numeric', 'min:10'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
    if ($validator->passes()) {
      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = $request->password;
      if ($user->save()) {
        $UserProfile = UserProfile::create([
          'user_id' => $user->id,
          // 'vendor_id' => 99,
          // minus one as admin vendor will be always 99
          'vendor_id' => str_pad(($user->id - 1), 2, "0", STR_PAD_LEFT),
          'phone' =>$request->phone,
        ]);
      }
      $token = Password::broker()->createToken($user);
      $resetURL = route('password.reset', ['token' => $token]);
      $resetURL  .= '?email='.$user->email;
      $user->notify(new OnBoardUser($user->name, $resetURL));
      Alert::success('Congrats', 'User Successfully Created');
      return redirect()->back();
    } else {
      Alert::error('Error', 'Some Error Occurred');
      return redirect()->back()->withErrors($validator)->withInput();
    }
  }

  public function edit($id) {
    $user = User::find($id);
    $roles = Role::all();
    $permissions = Permission::all();
    return view('admin.edit',compact('user','roles','permissions')); 
  }

  public function update($id, Request $request) {
    $user = User::find($id);
    $validator = Validator::make($request->all(),[
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
      'phone' => ['nullable', 'string', 'min:8'],
      'company_name' => ['nullable', 'string', 'max:255'],
      'company_address' => ['nullable', 'string', 'max:255'],
      'company_district' => ['nullable', 'string', 'max:255'],
      'company_state' => ['nullable', 'string', 'max:255'],
      'company_pincode' => ['nullable', 'string', 'max:255'],
      'address' => ['nullable', 'string', 'max:255'],
      'LicenseNumber' => ['nullable'],
      'CIBRegistrationCertificate' => ['nullable'],
      'profile_pic' => ['nullable'],
    ]);
    if ($validator->passes() ) {
      $user = User::find($id);
      $user_profile = UserProfile::find($id);
      $user->name = $request->name;
      $user->email = $request->email;
      $user_profile->phone = $request->phone;
      $user_profile->company_name = $request->company_name;
      $user_profile->company_address = $request->company_address;
      $user_profile->company_district = $request->company_district;
      $user_profile->company_state = $request->company_state;
      $user_profile->company_pincode = $request->company_pincode;
      // $user_profile->address = $request->address;
      $user_profile->LicenseNumber = $request->LicenseNumber;
      $user_profile->CIBRegistrationCertificate = $request->CIBRegistrationCertificate;
      if ( $request->hasFile('profile_pic') ) {
        $user_profile->profile_pic = $request->profile_pic;
        $image_new_name = time() . $user_profile->profile_pic->getClientOriginalName();
        $user_profile->profile_pic->move('images',$image_new_name);
        $user_profile->profile_pic= 'images/' . $image_new_name;
      }
      $user_profile->save();
      $user->save();
      Alert::success('Success', 'User Successfully Updated');
      return redirect()->route('users.edit',$id);
    } else {
      /*$this->pr($validator->errors());
      exit;*/
      Alert::error('Error', 'Some Error Occurred');
      return redirect()->route('users.edit',$id)->withErrors($validator)->withInput();
    }
  }

  public function passwordupdate($id, Request $request) {
    $user = User::find($id);
    $validator = Validator::make($request->all(),[
      'old_password' => ['required', 'string'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
    if( $validator->passes() ) {
      $user = User::find($id);
      $password = $user->password;
      if ('true' == Hash::check($request->old_password,$password) ) { 
        $user->password = $request->password;
        $user->save();
        Alert::success('Success', 'Password Successfully Updated');
        return redirect()->route('users.edit',$id);
      } else {
        Alert::error('Error', 'Old Password Did Not Match');
        return redirect()->route('users.edit',$id)->withErrors($validator)->withInput();
      }
    } else {
      Alert::error('Error', 'Some Error Occurred');
      return redirect()->route('users.edit',$id)->withErrors($validator)->withInput();
    }
  }

  public function destroy($id, Request $request) {
    $user = User::find($id);
    $user->delete(); 
    Alert::success('Success', 'User Deleted Successfully');
    return redirect()->back();
  }

  public function deleteUsers(Request $request){
    $ids = $request->ids;
    if ( $ids != null ) {
      $user = User::whereIn('id', $ids)->get();
      User::whereIn('id', $ids)->delete();
      Alert::success('Success', 'User Deleted Successfully');
      return redirect()->back();
    } else {
      Alert::error('Error', 'Please Select At Least One Record');
      return redirect()->back();
    }      
  }

  public function givePermission(Request $request, User $user) {
    if ($user->hasPermissionTo($request->permission)) {
      Alert::error('Error', 'Permission Exsit');
      return redirect()->back();   
    } 
    $user->givePermissionTo($request->permission);
    Alert::success('Success', 'Permission Assign This User Successfully');
    return redirect()->back();
  }

  public function revokePermission(User $user, Permission $permission ) {
    if ($user->hasPermissionTo($permission)) {
      $user->revokePermissionTo($permission);
      Alert::success('Success', 'Permission Revoked This User Successfully');
      return redirect()->back();   
    } 
    Alert::error('Error', 'Permission Not Exsit');
    return redirect()->back();
  }

  public function assignRole(Request $request, User $user) {
    if ($user->hasRole($request->role)) {
      Alert::error('Error', 'Role Exsit');
      return redirect()->back();   
    } 
    $user->assignRole($request->role);
    Alert::success('Success', 'Role Assign This User Successfully');
    return redirect()->back();
  }

  public function removeRole(User $user,Role $role ) {
    if ($user->hasRole($role)) {
      $user->removeRole($role);
      Alert::success('Success', 'Role Revoked This User Successfully');
      return redirect()->back();   
    } 
    Alert::error('Error', 'Role Not Exsit');
    return redirect()->back();
  }

  public function updateStatus($user_id, $status_code)
  {
    try{
      $update_user = User::whereId($user_id)->update([
        'status'=>$status_code
      ]);

      if($update_user){
        return redirect()->route('users.index')->with('success','User Status Updated 
        Successfully');
      }
      return redirect()->route('users.index')->with('error','Failed to update User status');
    }
    catch(\Throwable $th){
      throw $th;
    }
  }
}
