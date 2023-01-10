<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminProfileRequest;
use App\Models\Laugh;
use App\Models\SiteVisitHistory;
use Exception;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    // Create a new controller instance.
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show the application dashboard.
    public function index()
    {
        $title = 'Dashboard';
        $statistics = Cache::remember('statistics', 60 * 2, function () {
            $users =  User::RoleUser()->count();
            $statisticArray = [
                [
                    'title' => 'Users',
                    'count' => $users,
                    'route' => 'users.index',
                    'class' => "bg-warning",
                    'icon' => 'fas fa-users'
                ]
            ];
            return $statisticArray;
        });
        return view('admin.home', compact('title', 'statistics'));
    }

    // Show the user profile.
    public function profile()
    {
        $title = 'Profile';
        $user = Auth::user();
        return view('admin.profile', compact('title'))->with('user', $user);
    }

    // Admin profile profile.
    public function UpdateAdminProfile(AdminProfileRequest $request)
    {
        try {
            $post_data = $request->validated();
            $valid_user = User::find($request->id);
            if ($valid_user == null) {
                return error('Invalid user detail!');
            }
            if (isset($post_data['image']) && $post_data['image'] != '') {
                $img = FileUploadHelper($post_data['image'], 'profile');
                $post_data['image'] = $img;
                if ($valid_user->image != '') {
                    $path = base_path() . '/' . $valid_user->image;
                    destroyFileHelper($path);
                }
            } else {
                unset($post_data['image'], $post_data['confirm_password']);
            }
            $post_data['image'] = (@$post_data['image'] != '') ? $post_data['image'] : $valid_user->image;
            $post_data['password'] = (@$post_data['password'] != '') ? bcrypt($post_data['password']) : $valid_user->password;
            unset($post_data['confirm_password']); //edit
            User::where('id', $request->id)->update($post_data);
            return success('Profile updated successfully.', $post_data['image']);
        } catch (Exception $e) {
            return error('Something went wrong!', $e->getMessage());
        }
    }
}
