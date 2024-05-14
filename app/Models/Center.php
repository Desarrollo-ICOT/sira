<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;
    protected $fillable = ['code'];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public static function getCodeByDeviceIP($ip)
    {
        $device = Device::where('ip', $ip)->first();
        if ($device) {
            return $device->center->code;
        }
        return null;
    }
    public static function getCodeByDevicePrivateIP($ip)
    {
        $device = Device::where('ipprivada', $ip)->first();
        if ($device) {
            return $device->center->code;
        }
        return null;
    }
    public static function getCodeBySubnet($subnet)
    {
        $device = Device::where('subnet', $subnet)->first();
        if ($device) {
            return $device->center->code;
        }
        return null;
    }
}
