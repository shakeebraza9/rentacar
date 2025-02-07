<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donor;
use App\Models\ApplicationType;
use App\Models\DocumentType;
use App\Models\Maddat;
use App\Models\PlaceType;
use App\Models\PropertyType;
use App\Models\ApplicationDonor;
use App\Utilities\HierarchyUtility;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\DonorRequest;
use App\Models\Filemanager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\DB;

class FilemanagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
       
        $groups = Filemanager::query()->pluck('grouping')->toArray();
        $groups = array_unique($groups);


        $data = Filemanager::query();

        if($request->has('group') && $request->group != ''){
          $data = $data->where('grouping',$request->group);
        }

        $data = $data->paginate(20);
    
        return view('admin.filemanager.index',compact('data','groups'));
    } 


    public function create(Request $request)
    {

        return view('admin.filemanager.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => ['max:255'],
            'group' => ['required','max:255'],
            'description' =>['max:255'],
            'files.*' => ['required','file','mimes:jpg,png,pdf','max:2048'],
        ]);

        if(count($request->files) == 0){
            return back()->with('warning','File Not Found');
        }
        

        foreach ($request->files as $files) {
            foreach ($files as $myfile) {

                $fileExtension = $myfile->getClientOriginalExtension();
                $fileSizeInBytes = $myfile->getSize();
                $mimeType = $myfile->getMimeType();
                $fileTitle = pathinfo($myfile->getClientOriginalName(), PATHINFO_FILENAME);        
                $filename = uniqid().'.'.$fileExtension;
                $path = 'filemanager/'.$filename;
                $upload_path = base_path('public/filemanager');
                $myfile->move($upload_path,$filename);

                $filemanager = new Filemanager();
                $filemanager->filename = $filename;
                if($request->title == ''){
                    $filemanager->title = $filename;
                }else{
                    $filemanager->title = $fileTitle;
                }
                
                $filemanager->size = $fileSizeInBytes;
                $filemanager->type = $mimeType;
                $filemanager->extension = $fileExtension;
                $filemanager->path = $path;
                $filemanager->preview = asset($path);
                $filemanager->save();

            }

        }

        return redirect('/admin/filemanager')->with('success','File Uploaded');
    }

    public function edit($id){

        $filemanager = Filemanager::find($id);
        if($filemanager == null){
            return back();
        }

        return view('admin.filemanager.edit',compact('filemanager'));
    }


    public function update(Request $request,$id)
    {  

        $filemanager = Filemanager::find($id);
        if($filemanager == null){
            return back();
        }

         $request->validate([
            'title' => ['max:255'],
            'group' => ['required','max:255'],
            'description' =>['max:255'],
        ]);

        $filemanager->title = $request->title;
        $filemanager->grouping = $request->group;
        $filemanager->description = $request->description;
        $filemanager->save();

        return back()->with('success','File Uploaded');

    }


    public function delete($id)
    {
        $filemanager = Filemanager::find($id);
        if($filemanager == null){
            return back();
        }

        // dd(public_path($filemanager->path));

        if (file_exists(public_path($filemanager->path))) {
            if (unlink(public_path($filemanager->path))) {
                // echo 'File removed successfully.';

            } else {
                // echo 'Unable to remove the file.';
            }
        } 


        $filemanager->delete();
        return back()->with('success','Deleted');

    }

    
}
