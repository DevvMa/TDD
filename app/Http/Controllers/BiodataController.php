<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\User;
use Illuminate\Http\Request;

class BiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email'=> 'required|email|unique:users',
            'password'=> 'required',
            'nim'=> 'required|max:100',
            'tempat_lahir' => 'required|string', 
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P', 
            'alamat' => 'required'
        ]);
        $request->password=bcrypt($request->password);  
        $user = User::create($request->only(['name','email','password']));
        $request['user_id']=$user->id;
        $biodata = Biodata::create($request->only(['nim','user_id', 'tempat_lahir', 'tanggal_lahir','jenis_kelamin','alamat']));

        return response()->json(['msg'=>'Data Telah Ditambahkan'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('biodata')->findOrFail($id);
        return response()->json([
            'name'=>$user->name,
            'email'=>$user->email,
            'nim'=>$user->biodata->nim
        ],200);
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
        $request->validate([
            'name' => 'required|max:100',
            'email'=> 'required|email|unique:users',
            'nim'=> 'required|max:100',
            'tempat_lahir' => 'required|string', 
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P', 
            'alamat' => 'required'
        ]);
        $user = User::select('id', 'name', 'email')->with('biodata')->findOrFail($id);
        $user->update($request->only(['name', 'email']));
        $biodata = $user->biodata;
        $is_updated = Biodata::where('user_id', $user->id)->update($request->only(['nim','tempat_lahir', 'tanggal_lahir','jenis_kelamin','alamat']));
        return response()->json(['msg'=>'Data Telah Diubah'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::select('id')->findOrFail($id);
        Biodata::where('user_id', $user->id)->delete();
        $user->delete();

        return response()->json([
            'msg' => 'Data Telah Dihapus'
        ], 200);
    }
}
