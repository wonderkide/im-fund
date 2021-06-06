<?php
namespace app\components;

use Yii;
use yii\base\Component;
use app\components\WebsocketClient;
use app\controllers\NotificationController;
use yii\helpers\Url;

class WebsocketService extends Component {
    
    public function transactionNotification($created_by = '', $sound = true){
        $action = 'notification';
        $for = '#transaction';
        $count = NotificationController::getTransactionNotification()->count();
        $message = "&nbsp;&nbsp;แจ้งเตือนรายการ ($count รายการ)";
        $url = Url::to(['transaction/index']);
        
        $data = [
            'action' => $action,
            'for' => $for,
            'created_by' => $created_by,
            'count' => $count,
            'message' => $message,
            'url' => $url,
            'sound' => $sound
        ];
        
        $socket = new WebsocketClient();
        $result = $socket->sendToSocket($data);
        return $result;
    }
    
    public function transferNotification($created_by = '', $sound = true){
        $action = 'notification';
        $for = '#bank-transfer';
        $count = NotificationController::getBankTransferNotification()->count();
        $message = "&nbsp;&nbsp;แจ้งเตือนโอนเงิน ($count รายการ)";
        $url = Url::to(['bank-transfer/index']);
        
        $data = [
            'action' => $action,
            'for' => $for,
            'created_by' => $created_by,
            'count' => $count,
            'message' => $message,
            'url' => $url,
            'sound' => $sound
        ];
        
        $socket = new WebsocketClient();
        $result = $socket->sendToSocket($data);
        return $result;
    }
    
    public function nonUserNotification($created_by = '', $sound = true){
        $action = 'notification';
        $for = '.none-user';
        $count = NotificationController::GetNoneUserNotification()->count();
        $message = "&nbsp;&nbsp;แจ้งเตือนสมัครใหม่ ($count รายการ)";
        $url = Url::to(['member/none-user']);
        
        $data = [
            'action' => $action,
            'for' => $for,
            'created_by' => $created_by,
            'count' => $count,
            'message' => $message,
            'url' => $url,
            'sound' => $sound
        ];
        
        $socket = new WebsocketClient();
        $result = $socket->sendToSocket($data);
        return $result;
    }
}