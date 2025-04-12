<?php

namespace App\Controllers;

use App\Core\Controllers\Controller;
use App\Core\Helper\Session;
use App\Core\Helper\Validator;
use App\Enums\DreamStatus;
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

    public function accept()
    {
        $this->authed();
        $id = (int) $_REQUEST['id'];
        if (isset($id) && $id > 0) {
            $dream = Dream::find($id);
            if ($dream) {
                $dream->status = DreamStatus::Approved->value;
                if ($dream->save()) {
                    Session::put('dream-updated', 'تم تعديل الحلم');
                } else {
                    Session::error('updated-dream-error', 'لم يتم تعديل الحلم');
                }
            } else {
                Session::error('updated-dream-error', 'اختيار غير صحيح');
            }
        } else {
            Session::error('updated-dream-error', 'لم يتم تعديل الحلم');
        }
        redirect(back());
    }
}
