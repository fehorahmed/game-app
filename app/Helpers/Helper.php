<?php

namespace App\Helpers;

use App\Models\GlobalConfig;
use App\Modules\CoinManagement\Models\UserCoin;

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
}
