<?php

namespace App\Controllers\Admin;

use App\Core\Controllers\Controller;
use App\Core\Helper\Session;
use App\Core\Helper\Validator;
use App\Models\Dream;

class DashboardController extends Controller
{

    public function create()
    {
        $this->authed();
        $dreams = Dream::query()->deleted()->get();
        return view('admin/dashboard', [
            'dreams' => $dreams
        ]);
    }

    public function fulfill_dream()
    {
        $this->authed();
        $this->saveOld($_REQUEST);

        $minAmount = $_REQUEST['minAmount'];
        $maxAmount = $_REQUEST['maxAmount'];
        $matchingDreams = Dream::query()->amount($minAmount, $maxAmount)
            ->get();
        if (isset($_REQUEST['select_random'])) {
            redirect('/admin/random', $_REQUEST);
        } else {

            $data = [
                "minAmount" => $minAmount,
                "maxAmount" => $maxAmount,
                'matchingDreams' => $matchingDreams
            ];

            return view('admin/fulfilldream', $data);
        }
    }

    public function random_dream()
    {
        $this->authed();
        $minAmount = $_REQUEST['minAmount'];
        $maxAmount = $_REQUEST['maxAmount'];

        $dream = Dream::query()->amount($minAmount, $maxAmount)->get()->random();
        return view('admin/dream', [
            'randomDream' => $dream,
            "minAmount" => $minAmount,
            "maxAmount" => $maxAmount,
        ]);
    }


    public function delete_dream()
    {
        $this->authed();
        $id = (int) $_REQUEST['id'];
        if (isset($id) && $id > 0) {
            $dream = Dream::find($id);
            if ($dream) {
                if ($dream->softDelete()) {
                    Session::put('dream-deleted', 'تم حذف الحلم');
                } else {
                    Session::error('delete-dream-error', 'لم يتم حذف الحلم');
                }
            } else {
                Session::error('delete-dream-error', 'اختيار غير صحيح');
            }
        } else {
            Session::error('delete-dream-error', 'لم يتم حذف الحلم');
        }
        redirect(back());
    }
}
