<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Resources\CategorieResource;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Categorie::paginate(10);
    
        return view('categorie.index',compact('data'));
    }

    public function index1(Request $request)
    { 
        //$categorie = Categorie::all();
        
        $categorie = Categorie::select('*');
        if($request->filled('colore')) {
            $color = $request->query('colore');
        $categorie = $categorie->where('colore', '=', $color);
        }
        $categorie = $categorie->get();
        
        return response([ 'categorie' => 
        CategorieResource::collection($categorie), 
        ], 200);
    }
    
    public function index2($id)
    { 
        //try {
        $categorie = Categorie::findOrFail($id)->toArray();
        //}
        //catch(Exception $e)
       // {
       // return response()->json(['status' => 'failed', 'data' => null, 'message' => 'Category not found']);
       // }
        
        return response([ 'categorie' => 
        new CategorieResource($categorie), 
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorie.create');
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
            'categoria' => 'required',
            'colore' => 'required',
            'codice' => 'required'
        ]);
    
        Categorie::create($request->all());
     
        return redirect()->route('categorie.index')
                        ->with('success','Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Categorie $categorie)
    {
        return view('categorie.show',compact('categorie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit($id_categoria)
    {
        $categoria = Categorie::find($id_categoria);
        return view('categorie.edit',compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categorie $categorie)
    {
        $request->validate([
            'categoria' => 'required',
            'colore' => 'required',
            'codice' => 'required'
        ]);
    
        $categorie->update($request->all());
    
        return redirect()->route('categorie.index')
                        ->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();
    
        return redirect()->route('categorie.index')
                        ->with('success','Category deleted successfully');
    }
}
