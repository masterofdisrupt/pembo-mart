<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    use HasFactory;

    protected $table = 'home_settings';


    public static function getSingleRecord()
    {
        return self::first();
    }

    public function getPaymentImage()
    {
        if(!empty($this->payment_delivery_image) && file_exists(public_path('backend/upload/setting/' . $this->payment_delivery_image))) {
        
        return url('public/backend/upload/setting/' . $this->payment_delivery_image);
    }
    return null;
    }

    public function getRefundImage()
    {
        if(!empty($this->refund_image) && file_exists(public_path('backend/upload/setting/' . $this->refund_image))) {
        
        return url('public/backend/upload/setting/' . $this->refund_image);
    }
    return null;
    }

    public function getSupportImage()
    {
        if(!empty($this->support_image) && file_exists(public_path('backend/upload/setting/' . $this->support_image))) {
        
        return url('public/backend/upload/setting/' . $this->support_image);
    }
    return null;
    }

    public function getSignupImage()
    {
        if(!empty($this->signup_image) && file_exists(public_path('backend/upload/setting/' . $this->signup_image))) {
        
        return url('public/backend/upload/setting/' . $this->signup_image);
    }
    return null;
    }


}
