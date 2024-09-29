<?php

namespace App\Helpers;

use App\Models\GlobalConfig;
use App\Models\StarConfig;
use App\Modules\CoinManagement\Models\UserCoin;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class Helper
{

    public static function Helpertest()
    {



        return 'text valurr';
    }
    /**
     * @param $key
     * @param bool $array
     *
     * @return array|null
     */
    public static function get_config($key, $array = FALSE)
    {

        $config = GlobalConfig::where('key', $key)->first();
        if ($array) {
            $value = [];
            if ($config !== NULL) {
                $value = explode(',', trim($config->value));
            }
        } else {
            $value = NULL;
            if ($config !== NULL) {
                $value = trim($config->value);
            }
        }

        return $value;
    }

    public static function get_star_config($key, $array = FALSE)
    {

        $config = StarConfig::where('key', $key)->first();
        if ($array) {
            $value = [];
            if ($config !== NULL) {
                $value = explode(',', trim($config->value));
            }
        } else {
            $value = NULL;
            if ($config !== NULL) {
                $value = trim($config->value);
            }
        }

        return $value;
    }
    public static function get_star_price($count)
    {
        if ($count > 0) {
            if ($count == 1) {
                $value = self::get_star_config('one_star_price');
            } elseif ($count == 2) {
                $value = self::get_star_config('two_star_price');
            } elseif ($count == 3) {
                $value = self::get_star_config('three_star_price');
            } elseif ($count == 4) {
                $value = self::get_star_config('four_star_price');
            } elseif ($count == 5) {
                $value = self::get_star_config('five_star_price');
            } elseif ($count == 6) {
                $value = self::get_star_config('six_star_price');
            } elseif ($count == 7) {
                $value = self::get_star_config('seven_star_price');
            } elseif ($count == 8) {
                $value = self::get_star_config('eight_star_price');
            } elseif ($count == 9) {
                $value = self::get_star_config('nine_star_price');
            } else {
                $value = self::get_star_config('ten_star_price');
            }
        } else {
            $value = 0;
        }

        return $value;
    }
    public static function get_star_withdraw_limit($count)
    {
        if ($count > 0) {
            if ($count == 0) {
                $value = self::get_star_config('zero_start_withdraw');
            } elseif ($count == 1) {
                $value = self::get_star_config('one_star_withdraw');
            } elseif ($count == 2) {
                $value = self::get_star_config('two_star_withdraw');
            } elseif ($count == 3) {
                $value = self::get_star_config('three_star_withdraw');
            } elseif ($count == 4) {
                $value = self::get_star_config('four_star_withdraw');
            } elseif ($count == 5) {
                $value = self::get_star_config('five_star_withdraw');
            } elseif ($count == 6) {
                $value = self::get_star_config('six_star_withdraw');
            } elseif ($count == 7) {
                $value = self::get_star_config('seven_star_withdraw');
            } elseif ($count == 8) {
                $value = self::get_star_config('eight_star_withdraw');
            } elseif ($count == 9) {
                $value = self::get_star_config('nine_star_withdraw');
            } else {
                $value = 20000;
            }
        } else {
            $value = 0;
        }

        return $value;
    }

    public static function game_init_coin_exist($user_id)
    {
        $u_coin = UserCoin::where('app_user_id', $user_id)->first();
        $config = GlobalConfig::where('key', 'game_initialize_coin_amount')->first();
        if ($u_coin->coin >= $config->value) {
            return true;
        } else {
            return false;
        }
    }



    public static function saveImage($destination, $attribute, $width = null, $height = null): string
    {
        if (!File::isDirectory(base_path() . '/public/uploads/' . $destination)) {
            File::makeDirectory(base_path() . '/public/uploads/' . $destination, 0777, true, true);
        }

        if ($attribute->extension() == 'svg') {
            $file_name = time() . '-' . $attribute->getClientOriginalName();
            $path = 'uploads/' . $destination . '/' . $file_name;
            $attribute->move(public_path('uploads/' . $destination . '/'), $file_name);
            return $path;
        }

        $img = Image::make($attribute);
        if ($width != null && $height != null && is_int($width) && is_int($height)) {
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $returnPath = 'uploads/' . $destination . '/' . time() . '-' . Str::random(10) . '.' . $attribute->extension();
        $savePath = base_path() . '/public/' . $returnPath;
        $img->save($savePath);
        return $returnPath;
    }


    public static function saveFile($destination, $attribute): string
    {
        if (!File::isDirectory(base_path() . '/public/uploads/' . $destination)) {
            File::makeDirectory(base_path() . '/public/uploads/' . $destination, 0777, true, true);
        }

        $file_name = time() . '-' . $attribute->getClientOriginalName();
        $path = 'uploads/' . $destination . '/' . $file_name;
        $attribute->move(public_path('uploads/' . $destination . '/'), $file_name);
        return $path;
    }


    public static function deleteFile($path)
    {
        File::delete($path);
    }

    public static function getFile($file)
    {
        return asset($file);
    }
}
