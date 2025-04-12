<?php 

namespace App\Enums; 
enum DreamStatus: string {
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}