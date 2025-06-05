<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $table = 'system_settings';

    public static function getSingleRecord()
    {
        return self::find(1);
    }

    public function getLogo()
{
    if(!empty($this->logo) && file_exists(public_path('backend/upload/setting/' . $this->logo))) {
        
        return url('public/backend/upload/setting/' . $this->logo);
    }
    return null;
}

    public function getFavicon()
    {
        if(!empty($this->favicon) && file_exists(public_path('backend/upload/setting/' . $this->favicon))) {
            
            return url('public/backend/upload/setting/' . $this->favicon);
        }
        return null;
    }

    public function getFooterPaymentIcon()
    {
        if(!empty($this->footer_payment_icon) && file_exists(public_path('backend/upload/setting/' . $this->footer_payment_icon))) {
            
            return url('public/backend/upload/setting/' . $this->footer_payment_icon);
        }
        return null;
    }


}
