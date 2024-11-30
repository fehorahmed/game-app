<?php

namespace App\Helpers;

use App\Models\GlobalConfig;
use App\Models\StarConfig;
use App\Models\User;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUserBalance\Models\LevelIncomeLog;
use App\Modules\CoinManagement\Models\UserCoin;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class Helper
{
    protected static $referral_user_ids = [];

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
    public static function get_star_coin_transfer_limit($count)
    {
        if ($count > 0) {
            if ($count == 0) {
                $value = self::get_star_config('zero_start_coin_transfer');
            } elseif ($count == 1) {
                $value = self::get_star_config('one_star_coin_transfer');
            } elseif ($count == 2) {
                $value = self::get_star_config('two_star_coin_transfer');
            } elseif ($count == 3) {
                $value = self::get_star_config('three_star_coin_transfer');
            } elseif ($count == 4) {
                $value = self::get_star_config('four_star_coin_transfer');
            } elseif ($count == 5) {
                $value = self::get_star_config('five_star_coin_transfer');
            } elseif ($count == 6) {
                $value = self::get_star_config('six_star_coin_transfer');
            } elseif ($count == 7) {
                $value = self::get_star_config('seven_star_coin_transfer');
            } elseif ($count == 8) {
                $value = self::get_star_config('eight_star_coin_transfer');
            } elseif ($count == 9) {
                $value = self::get_star_config('nine_star_coin_transfer');
            } elseif ($count == 10) {
                $value = self::get_star_config('ten_star_coin_transfer');
            } else {
                $value = 10000000;
            }
        } else {
            $value = 0;
        }

        return $value;
    }

    public static function get_level_income_percent($count)
    {
        if ($count > 0) {
            if ($count == 0) {
                $value = self::get_star_config('zero_level_percent');
            } elseif ($count == 1) {
                $value = self::get_star_config('one_level_percent');
            } elseif ($count == 2) {
                $value = self::get_star_config('two_level_percent');
            } elseif ($count == 3) {
                $value = self::get_star_config('three_level_percent');
            } elseif ($count == 4) {
                $value = self::get_star_config('four_level_percent');
            } elseif ($count == 5) {
                $value = self::get_star_config('five_level_percent');
            } elseif ($count == 6) {
                $value = self::get_star_config('six_level_percent');
            } elseif ($count == 7) {
                $value = self::get_star_config('seven_level_percent');
            } elseif ($count == 8) {
                $value = self::get_star_config('eight_level_percent');
            } elseif ($count == 9) {
                $value = self::get_star_config('nine_level_percent');
            } elseif ($count == 10) {
                $value = self::get_star_config('ten_level_percent');
            } else {
                $value = 0;
            }
        } else {
            $value = 0;
        }

        return $value;
    }


    public static function level_income_user_check($star_number)
    {

        $need_user = null;
        $current_referral_id = auth()->user()->referral_id;  // Start with the authenticated user's referral_id

        for ($i = 1; $i <= $star_number; $i++) {
            if (!$current_referral_id) {
                break;  // If there's no referral_id at any level, stop the loop
            }

            // Find the user with the current referral_id
            $current_user = AppUser::where('user_id', $current_referral_id)->first();

            if (!$current_user) {
                break;  // If no user is found, stop the loop
            }

            // Set the $need_user to the current user if it's the final iteration
            if ($i == $star_number) {
                $need_user = $current_user;
            }

            // Move to the next referral_id for the next iteration
            $current_referral_id = $current_user->referral_id;
        }

        return $need_user;
    }


    public static function ck_referral_user($user_id)
    {

        $users = AppUser::where('referral_id', $user_id)->get();

        foreach ($users as $item) {
            array_push(self::$referral_user_ids, $item->user_id);
            self::ck_referral_user($item->user_id);
        }
        // dd(self::$referral_user_ids);
        return self::$referral_user_ids;
    }
    public static function get_all_referral_user_ids($user_id=null)
    {
        self::$referral_user_ids = [];

        $id_to_check = $user_id ?? auth()->user()->user_id;
        $data =  self::ck_referral_user($id_to_check);
        return $data;
    }

    public static function get_level_gain($level)
    {
        $gains = LevelIncomeLog::where(['type' => 'GAIN', 'app_user_id' => auth()->id(), 'level_number' => $level])
            ->sum('amount');
        return $gains;
    }
    public static function get_level_gain_with_count($level)
    {
        $gains = LevelIncomeLog::where(['type' => 'GAIN', 'app_user_id' => auth()->id(), 'level_number' => $level])->get();
        $total = $gains->sum('amount');
        $count = $gains->count();
        if ($count > 0) {
            $avg = $total / $count;
        } else {
            $avg = $total;
        }
        $data= [
            'level'=>$level,
            'count'=>$count,
            'avg'=>$avg,
            'total'=>$total,
        ];
        return $data;
    }
    public static function get_level_loss($level)
    {
        $loss = LevelIncomeLog::where(['type' => 'LOSS', 'app_user_id' => auth()->id(), 'level_number' => $level])
            ->sum('amount');
        return $loss;
    }
    public static function get_level_loss_with_count($level)
    {
        $loss = LevelIncomeLog::where(['type' => 'LOSS', 'app_user_id' => auth()->id(), 'level_number' => $level])->get();
        $total = $loss->sum('amount');
        $count = $loss->count();
        if ($count > 0) {
            $avg = $total / $count;
        } else {
            $avg = $total;
        }
        $data= [
            'level'=>$level,
            'count'=>$count,
            'avg'=>$avg,
            'total'=>$total,
        ];
        return $data;
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
    public static function deposit_withdraw_status($id)
    {
        $arr = [
            '1' => 'Pending',
            '2' => 'Approved',
            '0' => 'Cancel',
        ];
        if (isset($arr[$id])) {
            return $arr[$id];
        } else {
            return '';
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
