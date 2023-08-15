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
        $address = Config::where('slug', 'address')->where('type',3)->first();
        $map = Config::where('slug', 'map')->where('type',3)->first();
        $phone = Config::where('slug', 'phone')->where('type',3)->first();
        $worktime = Config::where('slug', 'work-time')->where('type',3)->first();
        $email =Config::where('slug', 'email')->where('type',3)->first();
        $contact = [];
        $contact["address"] = $address;
        $contact["map"] = $map;
        $contact["phone"] = $phone;
        $contact["worktime"] = $worktime;
        $contact["email"] = $email;
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
            "message" =>"Cập nhật liên lạc thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
        
    }
   
}