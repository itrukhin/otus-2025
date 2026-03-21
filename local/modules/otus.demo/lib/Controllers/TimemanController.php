<?php
namespace Otus\Demo\Controllers;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Loader;

class TimemanController extends Controller
{
    public function configureActions(): array
    {
        return [
            'startWork' => ['prefilters' => []],
            'pauseWork' => ['prefilters' => []],
            'stopWork'  => ['prefilters' => []],
        ];
    }

    public function startWorkAction(): array
    {
        Loader::includeModule('timeman');

        $timeMan = new \CTimeManUser();
        if($timeMan->openDay()) {
            return [
                'status' => 'success',
                'message' => 'День начат'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Не удалось начать день'
            ];
        }
    }

    public function pauseWorkAction(): array
    {
        Loader::includeModule('timeman');

        $timeMan = new \CTimeManUser();
        if($timeMan->pauseDay()) {
            return [
                'status' => 'success',
                'message' => 'День приостановлен'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Не удалось приостановить день'
            ];
        }
    }

    public function stopWorkAction(): array
    {
        Loader::includeModule('timeman');

        $timeMan = new \CTimeManUser();
        if($timeMan->closeDay()) {
            return [
                'status' => 'success',
                'message' => 'День закончен'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Не удалось закончить день'
            ];
        }
    }

    public function restartWorkAction(): array
    {
        Loader::includeModule('timeman');

        $timeMan = new \CTimeManUser();
        if($timeMan->reopenDay()) {
            return [
                'status' => 'success',
                'message' => 'День возобновлен'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Не удалось возобновить день'
            ];
        }
    }
}