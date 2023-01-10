<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // get all user data
    public function index(Request $request)
    {
    	if ($request->ajax()){
            $data = User::where('role','=','user')->orderby('id','desc')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        $url = url('/').'/users/show/'.$row->id;
                        $url = "<div class='actions-a'><a class='btn btn-info btn-sm' onclick='view_user_modal(".$row->id.")' title='View'><i class='material-icons fas fa-eye'></i></a><a onclick='edit_user_modal(".$row->id.")' class='btn btn-primary btn-sm' title='Edit'><i class='fa fa-edit'></i></a><a onclick='DeleteData(".$row->id.")' class='btn btn-danger btn-sm' title='Delete'><i class='fa fa-trash'></i></a></div>";
                        return $url;
                    })
                    ->addColumn('image', function($row){
                        $image = '<img src="'.$row->image.'" class="img-fluid img-radius">';
                        return $image;
                    })
                    ->rawColumns(['actions','image'])
                    ->make(true);
        }
        $title =  'Users account';
        return view('users.index',compact('title'));
    }

    // add or edit user
    public function store(UserRequest $request)
    {
        try{
            $post_data = $request->validated();
            $post_data['role'] = User::USERROLE;
            $post_data['provider'] = 'email';
            if(isset($post_data['image']) && $post_data['image'] != null){
                $img = FileUploadHelper($post_data['image'],'profile');
                $post_data['image'] = $img;
            }
            if($request->id > 0 ){
                unset($post_data['email']);
            }
            unset($post_data['confirm_password']);
            User::updateOrCreate(['id'=>$post_data['id']],$post_data);
            $message =  $request->id > 0 ? 'User updated successfully.' : 'User added successfully.';
            return success($message);
        } catch(Exception $e) {
            return error('Something went wrong!');
        }
    }

    // get edit user details
    public function show($id)
    {
        try {
            $user = User::find($id);
            if(empty($user)){
                return response()->json(['status' => false, 'message'=>"Invalid user details"]);
            }
            $status = 'Blocked';
            if($user->status == 0){
                $status = 'Pending';
            }elseif($user->status == 1){
                $status = 'Active';
            }
            $user->status = $status;

            return success('Data get Successfully.', $user);
        } catch (\Exception $e) {
            return error('Something went wrong!',$e->getMessage());
        }
    }

    // Single user delete
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if (empty($user)) {
                return response()->json(['status' => false, 'message' => 'User not found']);
            }
            $user->delete();
            return success('User deleted successfully.');
        } catch (\Exception $e) {
           return error('Something went wrong!',$e->getMessage());
        }
    }

    // multiple user delete
    public function MultipleUserDelete(Request $request)
    {
        try {
            User::whereIn('id',$request->ids)->delete();
            return success('Users Deleted successfully.');
        } catch (\Exception $e) {
           return error('Something went wrong!',$e->getMessage());
        }
    }

    // Check email dublicate
    public function CheckEmailDublicate(Request $request)
    {
        try {
            echo (User::where('email','=',$request->email)->where('id','!=',$request->id)->count()>0) ? 'false' : 'true';
        } catch (\Exception $e) {
            echo 'true';
        }
    }
}
