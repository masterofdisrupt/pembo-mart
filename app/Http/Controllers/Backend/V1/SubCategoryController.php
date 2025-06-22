<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Backend\V1\SubCategoryModel;
use App\Models\Backend\V1\CategoryModel;

class SubCategoryController extends Controller
{
    public function sub_category()
    {
        $getRecord = SubCategoryModel::getRecords();
        return view('backend.admin.subcategory.list', compact('getRecord'));
    }

    public function sub_category_add()
    {
        $getCategory = CategoryModel::getRecords();
        return view('backend.admin.subcategory.add', compact('getCategory'));
    }

    public function sub_category_store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug',      
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->user()->id;

        SubCategoryModel::create($data);

        return redirect()->route('sub.category')->with('success', 'Sub Category added successfully.');
    }

    public function sub_category_edit($id)
    {
        $getCategory = CategoryModel::getRecords();
        $getRecord = SubCategoryModel::getRecordById($id);
        return view('backend.admin.subcategory.edit', compact('getRecord', 'getCategory'));
    }

   public function sub_category_update(Request $request, $id)
{
    $request->validate([
        'category_id' => 'required',
        'name' => 'required',
        'slug' => 'required|unique:sub_categories,slug,' . $id,
    ]);

    $data = $request->only([
        'category_id',
        'name',
        'slug',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ]);

    $data['created_by'] = auth()->user()->id;

    SubCategoryModel::where('id', $id)->update($data);

    return redirect()->route('sub.category')->with('success', 'Sub Category updated successfully.');
}

    public function sub_category_delete($id)
    {
        SubCategoryModel::where('id', $id)->update(['is_delete' => 1]);
        return redirect()->route('sub.category')->with('success', 'Sub Category deleted successfully.');
    }

    public function sub_category_status(Request $request)
    {
        $status = $request->status;
        $id = $request->id;

        SubCategoryModel::where('id', $id)->update(['status' => $status]);

        return response()->json(['success' => 'Status updated successfully.']);
    }

    public function get_sub_categories(Request $request)
{
    $category_id = $request->category_id;

    $subcategories = SubCategoryModel::getRecordSubCategory($category_id);
    $html = '';

    if ($subcategories->isNotEmpty()) {
        foreach ($subcategories as $subcategory) {
            $html .= '<option value="' . $subcategory->id . '">' . $subcategory->name . '</option>';
        }
    } else {
        $html .= '<option value="">No sub categories found</option>';
    }

    return response()->json(['html' => $html]);
}



}
