<?php

namespace App\Http\Controllers\Eventiz\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUsersController extends Controller
{
    // -----
    public function adminUserList(Request $request){

        $adminUsers = User::where('role_id',3)->orWhere('role_id',4)->get();

        return view('eventinz_admin.adminusers_management.adminusers_list', compact('adminUsers'));
    }
    public function addAdminUserForm(Request $request){

        $adminUsers = User::where('role_id',3)->orWhere('role_id',4)->get();

        return view('eventinz_admin.adminusers_management.adminusers_list', compact('adminUsers'));
    }
    public function addAdminUser(Request $request){

        $adminUsers = User::where('role_id',3)->orWhere('role_id',4)->get();

        return view('eventinz_admin.adminusers_management.adminusers_list', compact('adminUsers'));
    }
    public function editAdminUserForm(Request $request, $adminUserId){

        $adminUserFound = User::find($adminUserId);
        $adminRights = json_decode($adminUserFound->admin_rights);

        return view('eventinz_admin.adminusers_management.adminusers_edit', compact('adminUserFound','adminRights'));
    }
    public function updateAdminUser(Request $request, $adminUserId){

        $adminUsers = User::where('role_id',3)->orWhere('role_id',4)->get();

        return view('eventinz_admin.adminusers_management.adminusers_list', compact('adminUsers'));
    }
    public function deleteAdminUserForm(Request $request, $adminUserId){

        $adminUsers = User::where('role_id',3)->orWhere('role_id',4)->get();

        return view('eventinz_admin.adminusers_management.adminusers_list', compact('adminUsers'));
    }
    public function deleteAdminUser(Request $request, $adminUserId){

        $adminUsers = User::where('role_id',3)->orWhere('role_id',4)->get();

        return view('eventinz_admin.adminusers_management.adminusers_list', compact('adminUsers'));
    }
}
