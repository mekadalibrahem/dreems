<?php

namespace App\Controllers;

use App\Core\Controllers\Controller;
use App\Core\Helper\Session;
use App\Core\Helper\Validator;
use App\Models\Dream;
use App\Traits\FileUploadTrait;


class DreamController extends Controller
{
    use FileUploadTrait;

    public  function create()
    {
        view('dream/create');
    }
    public  function store()
    {


        $requets_data = $_REQUEST;
        $this->saveOld($requets_data);
        // validation
        Validator::validate($requets_data, [
            'fullName' => ['required'],
            'dreamDescription' => ['required'],
            'dreamAmount' => ['required'],
        ]);
        //  upload image file 
        $status = $this->uploadFile('dreamImage');
        if ($status['status'] == true) {
            $file_name = $status['file_name'];
            // insert data in database
            $dream = new Dream();
            $dream->full_name = $requets_data['fullName'];
            $dream->description = $requets_data['dreamDescription'];
            $dream->amount = $requets_data['dreamAmount'];
            $dream->image_path = $file_name ?? null;
            if ($dream->save()) {
                Session::flash('success_message', 'تم ارسال الحلم بنجاح');
                // redirect to success page
                redirect('/dream/create');
            } else {
                Session::flash('error_message', 'لم يتم ارسال الحلم بنجاح');
                // redirect to error page
                redirect('/dream/create');
            }
        } else {
            Session::error('dreamImage', $status['error_message']);
            // redirect to error page
            redirect('/dream/create');
        }
    }
}
