<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DataTables;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $breadcrumbs = [
            ['link'=>"dashboard-analytics",'name'=>"Home"], ['link'=>"dashboard-analytics",'name'=>"Pages"], ['name'=>"User List"]
        ];
        return view('/system/users/index', [
            'breadcrumbs' => $breadcrumbs,
            'users' => $users,
        ]);
    }

    public function getUser(Request $request)
    {
        $data = User::find($request->id);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        // try {
            
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            //dd($validator->fails());
            if ($validator->fails()) {
                //Alert::success('Error', $validator->errors());
                return response()->json(['error']);
            }

            //Alert::success('Success', 'Data has been saved');
            //return redirect()->route('users.index');
            return response()->json(['success']);
        // } catch (\Throwable $th) {
        //     return response()->json(['data' => 'error']);
        // }
        
        
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

    public function table(Request $request){
        $data = User::query();
        //dd($data);
        $dataTable = DataTables::eloquent($data)
        ->filterColumn('name', function($query, $keyword){
            $query->where('name','ilike',"%$keyword%");
        })
        ->filterColumn('email', function($query, $keyword){
            $query->where('email','ilike',"%$keyword%");
        });
        return response()->json($dataTable);
    }
}
