<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('roles as r')
            ->leftJoin('users as u','r.id','=','u.role_id')
            ->select('r.*', DB::raw('COUNT(u.id) as total_users'))
            ->groupBy('r.id','r.role')
            ->get();

        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a onclick="showData('.$row->id.')" class="show btn btn-warning btn-flat btn-sm"><i class="bi bi-eye-fill"></i></a>';
                $btn .= ' <a onclick="editData('.$row->id.')" class="edit btn btn-primary btn-flat btn-sm"><i class="bi bi-pencil-fill"></i></a>';
                $btn .= ' <a onclick="deleteData('.$row->id.')" class="delete btn btn-danger btn-flat btn-sm"><i class="bi bi-trash-fill"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:roles,role'
        ], [
            'role.required' => 'Le rôle est obligatoire.',
            'role.unique' => 'Ce rôle existe déjà.',
        ]);
           
        $data = DB::table('roles')->insert([
            'role' => $request->role,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
      
        return response()->json([
            'success' => 'Role enregistré avec succès !',
            'data' => $data,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = DB::table('roles')
            ->where('id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Rôle chargé avec succès !',
                'data' => $data,
                'status' => 200,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'role' => 'required|unique:roles,role,'.$id
        ], [
            'role.required' => 'Le rôle est obligatoire.',
            'role.unique' => 'Ce rôle existe déjà.',
        ]);
           
        $data = DB::table('roles')
            ->where('id', $id)
            ->update([
                'role' => $request->role,
                'updated_at' => Carbon::now()
            ]);
        
        return response()->json([
            'success' => 'Role modifié avec succès !',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('roles')->where('id', $id)->delete();
        return response()->json(['success' => 'Role supprimé avec succès !']);
    }
}
