<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;

class GenerateID
{

    /**
     * Generate id, I guess
     * 
     * @param string $model
     * @param string $prefix
     * @param int $padLength
     * @param string $id (default: 'id')
     * @return string|Exception
     */
    public static function generateId($model, string $prefix, int $padLength, string $id = 'id')
    {
        try {
            $latestData = $model
                ::orderByDesc($id)
                ->first();

            $startId = $latestData ? (int) substr($latestData[$id], strlen($prefix)) + 1 : 1;

            return $prefix . str_pad($startId, $padLength, 0, STR_PAD_LEFT);
            // return $startId;
        } catch (Exception $e) {
            Log::error('Error GenerateID, teuing bro: ' . $e->getMessage());
            return $e;
        }
    }
}