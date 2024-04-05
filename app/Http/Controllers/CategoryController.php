<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestPayloadValueResolver;

class CategoryController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Category::select('*'))
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" name="category_checkbox[]" data-id="'.$item->id.'" id="checkbox_'.$item->id.'" data-status="'.$item->status.'" class="checkbox category_checkbox" value="'.$item->id.'"/>';
            })
            ->addColumn('image', function($rows){
                $url= asset('category/'.$rows->image);
                if(!empty($rows->image)){
                    $image = '<img src="'.$url.'" alt="" height="100" width="100">';
                }else{
                    $image = 'Image not found';
                }
                
                return $image;
            })
            ->addColumn('action', 'categories.action')
            ->rawColumns(['checkbox','image','action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('categories.index');

    }
    
    public function create()
    {
        return view('categories.create');
    }
    
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'cat_name' => 'required|unique:categories',
            'image' => 'required',
            'parent_cat' => 'required'
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'category/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        Category::create($input);

     
        return redirect()->route('categories.index')->with('success','Category has been created successfully.');
    }
    
    public function show(Category $category)
    {
        return view('categories.show',compact('category'));
    } 
    
    public function edit(Category $category)
    {
        return view('categories.edit',compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cat_name' => 'required',
            'image' => 'required',
            'parent_cat' => 'required'
        ]);
        
        $category = Category::find($id);

        $category->cat_name = $request->cat_name;
        $category->parent_cat = $request->parent_cat;

        if ($image = $request->file('image')) {
            $destinationPath = 'category/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $category->image = "$profileImage";
        }
        // dd($category);

        $category->save();
    
        return redirect()->route('categories.index')->with('success','Category Has Been updated successfully');
    }
    
    public function destroy(Request $request)
    {
    
        $cat = Category::where('id',$request->id)->delete();
     
        return Response()->json($cat);
    }

    function removeAll(Request $request)
    {
        $cat_id_array = $request->id;
        $category = Category::whereIn('id', $cat_id_array);

        if($category->delete())
        {
            echo "Data Deleted";
        }
    }
}
