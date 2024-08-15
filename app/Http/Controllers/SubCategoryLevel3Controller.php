<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryLevel3Request;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategoryLevel3;
use Facade\Ignition\QueryRecorder\Query;
use Yajra\DataTables\DataTables;

class SubCategoryLevel3Controller extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];
        $pageTitle = trans('messages.list_form_title',['form' => trans('Subcategory Level 3')] );
        $auth_user = authSession();
        $assets = ['datatable'];
        $categories = Category::with('subcategories.subcategorieslevel3.subcategorieslevel4')->get();
        return view('subcategorylevel3.index',compact('pageTitle','auth_user','assets','filter','categories'));
    }

    public function index_data(DataTables $datatable, Request $request)
    {
        $query = SubCategoryLevel3::query(); // Initialize the query
         // Ensure filter is always an array
        $filter = $request->filter ?? [];

        // Apply filters
        if (isset($filter['column_status'])) {
            $query->where('status', $filter['column_status']);
        }

    
        // Include soft deleted records if the user is an admin
        if (auth()->user()->hasAnyRole(['admin'])) {
            $query->withTrashed();
        }
    
        // Generate the DataTables JSON response
        return $datatable->eloquent($query)
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row" id="datatable-row-' . $row->id . '" name="datatable_ids[]" value="' . $row->id . '" data-type="subcategorylevel3" onclick="dataTableRowCheck(' . $row->id . ', this)">';
            })
            ->editColumn('name', function ($query) {
                if (auth()->user()->can('subcategory edit')) {
                    return '<a class="btn-link btn-link-hover" href="' . route('subcategorylevel3.create', ['id' => $query->id]) . '">' . $query->name . '</a>';
                }
                return $query->name;
            })
            ->editColumn('subcategory_id', function ($query) {
                return $query->subcategory_id && $query->subcategory ? $query->subcategory->name : '-';
            })
            ->filterColumn('subcategory_id', function ($query, $keyword) {
                $query->whereHas('subcategory', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('is_featured', function ($query) {
                $disabled = $query->trashed() ? 'disabled' : '';
                return '<div class="custom-control custom-switch custom-switch-text custom-switch-color custom-control-inline">
                            <div class="custom-switch-inner">
                                <input type="checkbox" class="custom-control-input change_status" data-type="subcategory_featured" data-name="is_featured" ' . ($query->is_featured ? 'checked' : '') . ' ' . $disabled . ' value="' . $query->id . '" id="f' . $query->id . '" data-id="' . $query->id . '">
                                <label class="custom-control-label" for="f' . $query->id . '" data-on-label="' . __("messages.yes") . '" data-off-label="' . __("messages.no") . '"></label>
                            </div>
                        </div>';
            })
            ->addColumn('action', function ($data) {
                return view('subcategorylevel3.action', compact('data'));
            })
            ->editColumn('status', function ($query) {
                $disabled = $query->trashed() ? 'disabled' : '';
                return '<div class="custom-control custom-switch custom-switch-text custom-switch-color custom-control-inline">
                            <div class="custom-switch-inner">
                                <input type="checkbox" class="custom-control-input change_status" data-type="subcategory_status" ' . ($query->status ? 'checked' : '') . ' ' . $disabled . ' value="' . $query->id . '" id="' . $query->id . '" data-id="' . $query->id . '">
                                <label class="custom-control-label" for="' . $query->id . '" data-on-label="" data-off-label=""></label>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'status', 'check', 'is_featured', 'name'])
            ->toJson();
    }
    
    /* bulck action method */
    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        dd($request->all());
        $actionType = $request->action_type;

        $message = 'Bulk Action Updated';

        switch ($actionType) {
            case 'change-status':
                $branches = SubCategoryLevel3::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = 'Bulk Sub Category Level 3 Status Updated';
                break;
            
            case 'change-featured':
                $branches = SubCategoryLevel3::whereIn('id', $ids)->update(['is_featured' => $request->is_featured]);
                $message = 'Bulk Sub Category Level 3 Featured Updated';
                break;

            case 'delete':
                SubCategoryLevel3::whereIn('id', $ids)->delete();
                $message = 'Bulk Sub Category Level 3 Deleted';
                break;
                
            case 'restore':
                SubCategoryLevel3::whereIn('id', $ids)->restore();
                $message = 'Bulk Sub Category Level 3 Restored';
                break;
                
            case 'permanently-delete':
                SubCategoryLevel3::whereIn('id', $ids)->forceDelete();
                $message = 'Bulk Sub Category Level 3 Permanently Deleted';
                break;

                default:
                return response()->json(['status' => false,'is_featured' => false, 'message' => 'Action Invalid']);
                break;
        }

        return response()->json(['status' => true, 'is_featured' => true, 'message' => $message]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $auth_user = authSession();

        $subcategorylevel3 = SubCategoryLevel3::find($id);
        $pageTitle = trans('messages.update_form_title',['form'=>trans('subcategory level 3')]);
        
        if($subcategorylevel3 == null){
            $pageTitle = trans('messages.add_button_form',['form' => trans('subcategory level 3')]);
            $subcategorylevel3 = new SubCategoryLevel3;
        }
        $allSubcategorieslevel3 = SubCategoryLevel3::all();
        $categories = Category::with('subcategories.subcategorieslevel3')->get();
        return view('subcategorylevel3.create', compact('pageTitle' ,'subcategorylevel3' ,'auth_user','allSubcategorieslevel3' ,'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(SubCategoryRequest $request)
    // {
    //     if(demoUserPermission()){
    //         return  redirect()->back()->withErrors(trans('messages.demo_permission_denied'));
    //     }
    //     $data = $request->all();
       
    //     $data['is_featured'] = 0;
    //     if($request->has('is_featured')){
	// 		$data['is_featured'] = 1;
	// 	}
    //     if(!$request->is('api/*')) {
    //         if($request->id == null ){
    //             if(!isset($data['subcategory_image'])){
    //                 return  redirect()->back()->withErrors(__('validation.required',['attribute' =>'attachments']));
    //             }
    //         }
    //     }
    //     $result = SubCategory::updateOrCreate(['id' => $data['id'] ],$data);

    //     storeMediaFile($result,$request->subcategory_image, 'subcategory_image');

    //     $message = trans('messages.update_form',['form' => trans('messages.subcategory')]);
    //     if($result->wasRecentlyCreated){
    //         $message = trans('messages.save_form',['form' => trans('messages.subcategory')]);
    //     }
    //     if($request->is('api/*')) {
    //         return comman_message_response($message);
	// 	}
    //     return redirect(route('subcategory.index'))->withSuccess($message);    
    // }

    public function store(SubCategoryLevel3Request $request)
    {
        if (demoUserPermission()) {
            return redirect()->back()->withErrors(trans('messages.demo_permission_denied'));
        }

        // Validate and collect the request data
        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Check for required image file in non-API requests
        if (!$request->is('api/*') && $request->id === null) {
            if (!$request->hasFile('image')) {
                return redirect()->back()->withErrors(__('validation.required', ['attribute' => 'attachments']));
            }
        }
           // Handle image upload
           if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('categories', $imageName);
            $data['image'] = $imageName;
        }

        // Handle cover_image upload
        if ($request->hasFile('cover_image')) {
            $coverImageName = time().'_cover.'.$request->cover_image->extension();
            $request->cover_image->storeAs('categories', $coverImageName);
            $data['cover_image'] = $coverImageName;
        }

        // Update or create the subcategory
        $result = SubCategoryLevel3::updateOrCreate(['id' => $data['id']], $data);

        // Store the media file if present
        // if ($request->hasFile('subcategory_image')) {
        //     storeMediaFile($result, $request->file('subcategory_image'), 'subcategory_image');
        // }

        // Determine the success message
        $message = $result->wasRecentlyCreated
            ? trans('messages.save_form', ['form' => trans('subcategory level 3')])
            : trans('messages.update_form', ['form' => trans('subcategory level 3')]);

        // Return API or web response
        if ($request->is('api/*')) {
            return comman_message_response($message);
        }

        return redirect(route('subcategorylevel3.index'))->withSuccess($message);
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
        if(demoUserPermission()){
            return  redirect()->back()->withErrors(trans('messages.demo_permission_denied'));
        }
        $subcategorylevel3 = SubCategoryLevel3::find($id);
        $msg= __('messages.msg_fail_to_delete',['name' => __('subcategory level 3')] );
        
        if($subcategorylevel3!='') { 
            $subcategorylevel3->delete();
            $msg= __('messages.msg_deleted',['name' => __('subcategory level 3')] );
        }
        if(request()->is('api/*')) {
            return comman_message_response($msg);
		}
        return comman_custom_response(['message'=> $msg , 'status' => true]);
    }
    public function action(Request $request){
        $id = $request->id;

        $subcategorylevel3  = SubCategoryLevel3::withTrashed()->where('id',$id)->first();
        $msg = __('messages.not_found_entry',['name' => __('subcategory level 3')] );
        if($request->type == 'restore') {
            $subcategorylevel3->restore();
            $msg = __('messages.msg_restored',['name' => __('subcategory level 3')] );
        }
        if($request->type === 'forcedelete'){
            $subcategorylevel3->forceDelete();
            $msg = __('messages.msg_forcedelete',['name' => __('subcategory level 3')] );
        }
        if(request()->is('api/*')){
            return comman_message_response($msg);
		}
        return comman_custom_response(['message'=> $msg , 'status' => true]);
    }
}
