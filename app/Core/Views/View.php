<?php

namespace App\Core\Views;

use App\Core\Helper\Helper;
use Exception;


class  View
{
    protected $view;
    protected function __construct($view)
    {
        $full_path  = Helper::views_path() . $view . '.php';
        if (file_exists($full_path)) {
            $this->view = $view;
        } else {
            throw new Exception("ERROR VIEW {$view} NOT FOUND ");
        }
    }
    protected function render($data = [])
    {
        try {
            extract($data);
            include_once(Helper::views_path() . $this->view . '.php');
        } catch (\Throwable $th) {
            throw new Exception("ERROR including page {$this->view} NOT FOUND message : " . $th->getMessage());
        }
    }

    public static function view($view_name , $data = [])
    {
        try {
            $view = new self($view_name ,$data);
            return $view->render();
        } catch (\Throwable $th) {
            throw new Exception("ERROR Creating VIEW {$view_name}  message : " . $th->getMessage());
        }
    }
}
