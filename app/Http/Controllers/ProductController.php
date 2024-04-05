<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax()) {
            $data = Product::
            join('categories', 'products.cat_id', '=', 'categories.id')
            ->select( 'products.*','categories.cat_name','categories.id as category_id')
            ->orderBy('products.id','desc')
            ->get();
            // dd($data);

            return Datatables::of($data)
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" name="product_checkbox[]" data-id="'.$item->id.'" id="checkbox_'.$item->id.'" data-status="'.$item->status.'" class="checkbox product_checkbox" value="'.$item->id.'"/>';
            })
            ->addColumn('image', function($rows){
                // dd($rows);
                $url= asset('product/'.$rows->image);
                if(!empty($rows->image)){
                    $image = '<img src="'.$url.'" alt="" height="100" width="100">';
                }else{
                    $image = 'Image not found';
                }
                
                return $image;
            })
            ->addColumn('action', 'product.action')
            
            ->rawColumns(['checkbox','image','action'])
            ->addIndexColumn()
            ->make(true);
        }
        $categories = Category::all();
        return view('product.index', compact('categories'));

    }

    public function create()
    {
        $categories = Category::pluck('cat_name','id');
        // dd($categories);
        return view('product.create',compact('categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'description' => 'required',
            'cat_id' => 'required'
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'product/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
        Product::create($input);

        return redirect()->route('products.index')->with('success','Product has been created successfully.');
    }

    public function show(Product $product)
    {
        return view('product.show',compact('product'));
    } 
    
    public function edit(Product $product)
    {

        // return view('products')->with($product);

        $categories = Product::
        join('categories', 'products.cat_id', '=', 'categories.id')
        ->select( 'products.cat_id','categories.cat_name','categories.id as category_id')
        ->orderBy('products.id','desc')
        ->distinct()
        ->get();
        
            // dd($categories);
        return view('product.edit',compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            // 'image' => 'required',
            'description' => 'required',
            'cat_id' => 'required'
        ]);
        // dd($request);
        $category = Product::find($id);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->cat_id = $request->cat_id;

        if ($image = $request->file('image')) {
            $destinationPath = 'product/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $category->image = "$profileImage";
        }
        // dd($category);

        $category->save();
    
        return redirect()->route('products.index')->with('success','Category Has Been updated successfully');
    }
    
    public function destroy(Request $request)
    {
    
        $cat = Product::where('id',$request->id)->delete();
     
        return Response()->json($cat);
    }

    function removeAll(Request $request)
    {
        $cat_id_array = $request->id;
        $category = Product::whereIn('id', $cat_id_array);

        if($category->delete())
        {
            echo "Data Deleted";
        }
    }
}
