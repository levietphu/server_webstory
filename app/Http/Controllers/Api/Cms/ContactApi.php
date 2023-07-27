<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Http\Requests\AddContactRequest;
use App\Http\Requests\UpdateContactRequest;
use DB;
use Log;

class ContactApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = Config::where('type',3)->orderby("created_at","desc")->get();
        return [
        	"success" => true,
        	"status" => 200,
        	"contact" => $contact
        ];
    }
    public function create(AddContactRequest $req)
    {

        try{
            DB::beginTransaction();
            $logo = new Config;
            $logo->name= $req->name;
            $logo->slug= $req->slug;
            $logo->type= 3;
            $logo->value= $req->value;
            $logo->status= $req->status;
            $logo->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Thêm mới liên lạc thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return [
                "success" => false,
                "status" => 400,
                "message" => 'message:'.$exception->getMessage().'Line'.$exception->getLine()
            ];
        }
    	
    }
    public function edit($id)
    {
        $contact = Config::find($id);
        return [
            "success" => true,
            "status" => 200,
            "contact" => $contact
        ];
    }
    public function update(UpdateContactRequest $req,$id)
    {
        try{
            DB::beginTransaction();
            $contact = Config::find($id);
            $contact->name= $req->name;
            $contact->slug= $req->slug;
            $contact->value= $req->value;
            $contact->type= 3;
            $contact->status= $req->status;
            $contact->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Cập nhật liên lạc thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return [
                "success" => false,
                "status" => 400,
                "message" => 'message:'.$exception->getMessage().'Line'.$exception->getLine()
            ];
        }
        
    }
    public function hidden($id)
    {
        $contact = Config::find($id);
        $contact->status=0;
        $contact->save();
        return [
            "success" => true,
            "status" => 200,
            "messsage" => "Ẩn liên lạc thành công"
        ];
    }
}