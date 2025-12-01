<?php

namespace App\Http\Controllers\Help;

use Illuminate\Http\Request;
use App\Models\Help\Menu;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Session;
use Validator;
use Illuminate\Support\Facades\Storage;

class HelpMenuController extends Controller
{
    public function index(){
        $menus = Menu::where('parent_id', '=', 0)->where('delete_status','=',0)->get();
        $allMenus = Menu::where('delete_status','=',0)->pluck('title','id')->all();
        return view('Help.menuTreeview',compact('menus','allMenus'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required',
        ]);

        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        Menu::create($input);
        return back()->with('success', 'Menu added successfully.');
    }
    public function update(Request $request)
    {
        $request->validate([
           'title' => 'required',
        ]);
        $input = $request->all();
        $menu = Menu::find($input['id']);
        $menu->update($request->all());
        return back()->with('success', 'Menu updated successfully.');
    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        $menu = Menu::find($input['id']);
        $delete_status = array('delete_status' => 1);
        $menu->update($delete_status);
        if(count($menu->childs))
        {
            foreach($menu->childs as $child)
            {
                $this->delete_child($child->id);
            }
        }
        return back()->with('success', 'Menu deleted successfully.');
    }

    public function show()
    {
        $menus = Menu::where('parent_id', '=', 0)->get();
        return view('Help.dynamicMenu',compact('menus'));
    }

    public function delete_child($id)
    {
        $menu = Menu::find($id);
        $delete_status = array('delete_status' => 1);
        $menu->update($delete_status);
        if(count($menu->childs))
        {
            foreach($menu->childs as $child)
            {
                $this->delete_child($child->id);
            }
        }
        else
        {
            return true;
        }
    }

    public function addContent($id)
    {
        $menu = Menu::find($id);
        if($menu)
        {
            $data = unserialize($menu->menu_content);
            return view('Help.menuContent',compact('id','data'));
        }
        return redirect()->route('menus.index');
    }

    public function saveContent(Request $request)
    {
        $request->validate([
            'content_type' => 'required',
            'title' => 'required',
            'content' => 'required',
         ]);
         $input = $request->all();
         $menu = Menu::find($input['id']);
         $data = array('content_type'=>$input['content_type'],'title'=>$input['title'],'content'=>$input['content']);
         $menu_content = array('menu_content' => serialize($data));
         $menu->update($menu_content);
         return back()->with('success', 'Menu updated successfully.');
    }

    //upload images
    public function uploadImages(Request $request)
    {
        $input = $request->all();
        $CKEditor = $input['CKEditor'];
        $funcNum = $input['CKEditorFuncNum'];
        $message = $url = '';
        if ($request->hasFile('upload')) {
            $file = $input['upload'];
            $this->validation_rules = [
                'upload' => 'mimes:jpeg,jpg,gif,png'
            ];
            $validator = Validator::make($request->all(), $this->validation_rules);

            if ($validator->fails())
            {
                $message = 'Select JPG/JPEG/PNG images';
            }
            elseif ($file->isValid()) {
                $image = $request->file('upload');
                $imageFileName = time() . '.' . $image->getClientOriginalExtension();
                
                $filePath = date('YmdHis', time()) . '.' . $imageFileName;

                if(!Storage::disk('help_uploads')->put($filePath, file_get_contents($image))) {
                    return false;
                }
                $url =  '/help/'.$filePath;
            } else {
                $message = 'An error occured while uploading the file.';
            }
        } else {
            $message = 'No file uploaded.';
        }
        if($funcNum=='')
        {
            return response()->json(['fileName' => $imageFileName, 'uploaded' => 1, 'url' => $url]);
        }
        return '<script>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'", "'.$message.'")</script>';
    }
}