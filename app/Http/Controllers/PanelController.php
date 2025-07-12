<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelController extends Controller
{
    public function index()
    {
        // Nhúng dữ liệu user Khởi tạo layout
        $user = Auth::user();
        $roles = $user ? $user->roles : collect();

        $firstRole = $roles->first();

        $roleColor = $firstRole ? $firstRole->role_color : null;
        $roleName = $firstRole ? $firstRole->name : null;
        $data = [
            'roleColor' => $roleColor,
            'userRole' => $roleName,
            'userAlias' => $user->alias,
            'username' => $user->username,
            'userAvatar' => $user->avatar_url,
            'userCover' => $user->cover_url,
            'userId' => $user->id,
        ];

        return view('index', $data);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
