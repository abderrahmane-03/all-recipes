<?php

namespace App\Http\Controllers;

use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use App\Models\Recipe;
use League\CommonMark\Extension\DescriptionList\Node\Description;

class RecipesController extends Controller
{
    public function index(){
        $recipes= Recipe::all();
        return view('recipes.recipes',['recipes' => $recipes]);
    }
    public function create(){
        return view('recipes.create');
    }
    public function store(Request $request)
    {
        $file_extension = $request->image->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $path = 'images/offers';
        $request->image->move($path, $file_name);
    
        $data = $request->validate([
            'title' => 'required|min:6',
            'description' => 'required',
            'steps' => 'required',
            'cooking_time' => 'nullable',
            'image' => '',
            'category_id' => 'nullable',
        ]);
    
        $data['image'] = $file_name;
    
        
            Recipe::create($data);
            return redirect()->route('recipes.recipes');
       
    }
    public function edit(Recipe $recipe){
        return view ('recipes.edit',['recipe'=>$recipe]);
    }
       
    public function update(Recipe $recipe ,Request $request){
        $file_extension = $request->image->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $path = 'images/offers';
        $request->image->move($path, $file_name);
        $data = $request->validate([
            'title' => 'required|min:6',
            'description' => 'required',
            'steps' => 'required',
            'cooking_time' => 'nullable',
            'image' => '',
            'category_id' => 'nullable',
        ]);
        $data['image'] = $file_name;

        $recipe->update($data);
        return redirect()->route('recipes.recipes');
   
    }
    public function destroy(Recipe $recipe) {
 $recipe->delete();
 return redirect()->route('recipes.recipes');
   

    }
       
    
}
