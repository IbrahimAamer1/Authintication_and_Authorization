<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\HttpCache\Store;

class CategoryController extends Controller
{
    const DIRECTORY = 'back.categories';

    function __construct()
    {
        // $this->middleware('check_permission:manage_categories')->only(['index', 'getData']);
        // $this->middleware('check_permission:create_category')->only(['create', 'store']);
        // $this->middleware('check_permission:show_category')->only(['show']);
        // $this->middleware('check_permission:edit_category')->only(['edit', 'update']);
        // $this->middleware('check_permission:delete_category')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->getData($request->all());
        return view(self::DIRECTORY . ".index", \get_defined_vars())->with('directory', self::DIRECTORY);
    }

    /**
     * Get data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData($data)
    {
        $order   = $data['order'] ?? 'sort_order';
        $sort    = $data['sort'] ?? 'asc';
        $perpage = $data['perpage'] ?? 10;
        $start   = $data['start'] ?? null;
        $end     = $data['end'] ?? null;
        $word    = $data['word'] ?? null;
        $status  = $data['status'] ?? null;

        $data = Category::when($status !== null, function ($q) use ($status) {
            $q->where('is_active', $status);
        })
            ->when($word != null, function ($q) use ($word) {
                $q->where('name', 'like', '%' . $word . '%')
                    ->orWhere('description', 'like', '%' . $word . '%');
            })
            ->when($start != null, function ($q) use ($start) {
                $q->whereDate('created_at', '>=', $start);
            })
            ->when($end != null, function ($q) use ($end) {
                $q->whereDate('created_at', '<=', $end);
            })
            ->orderby($order, $sort)->paginate($perpage);

        return \get_defined_vars();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(self::DIRECTORY . ".create", get_defined_vars());
    }

  
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        // Set default values
        $data['is_active'] = $request->has('is_active') ? true : false;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Category::create($data);

        return response()->json(['success' => __('messages.sent') ?? 'Category created successfully']);
    }

 
    public function show(Category $category)
    {
        return view(self::DIRECTORY . ".show", \get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view(self::DIRECTORY . ".edit", \get_defined_vars());
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $imageName = time() . '.' . $request->file('image')->getClientOriginalName();
            $data['image'] = $request->file('image')->storeAs('categories', $imageName, 'public');
        }

        // Handle is_active
        $data['is_active'] = $request->has('is_active') ? true : false;

        $category->update($data);

        return response()->json(['success' => __('messages.updated') ?? 'Category updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Delete image if exists
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json(['success' => __('messages.deleted') ?? 'Category deleted successfully']);
    }
}
