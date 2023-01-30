<?php
namespace common\components;

use Yii;
use yii\base\Component;
use common\models\FundPortList;
use common\models\Fund;

class CalculateService extends Component {
    
    public function calculatePort($port){
        
        $status = false;
        $message = '';
        
        $transaction = Yii::$app->db->beginTransaction();
        try {
        
            $port_list = FundPortList::find()->where(['fund_port_id' => $port->id])->all();
            foreach ($port_list as $list) {
                $connection = Yii::$app->getDb();
                $command_b = $connection->createCommand("
                    SELECT SUM(nav) AS nav, SUM(amount) AS amount, SUM(units) AS units, COUNT(id) AS count_list
                    FROM fund_port_list_detail
                    WHERE fund_port_list_id = $list->id AND type = 1 AND status = 1
                    GROUP BY fund_port_list_id
                    ");
                $sum_buy = $command_b->queryOne();
                
                $command_s = $connection->createCommand("
                    SELECT SUM(nav) AS nav, SUM(amount) AS amount, SUM(profit_amount) AS profit_amount, SUM(units) AS units, COUNT(id) AS count_list
                    FROM fund_port_list_detail
                    WHERE fund_port_list_id = $list->id AND type = 2 AND status = 1
                    GROUP BY fund_port_list_id
                    ");
                $sum_sell = $command_s->queryOne();
                
                if($sum_sell){
                    $amount_sell = $sum_sell['amount'];
                    $units_sell = $sum_sell['units'];
                    $Profit_amount_sell = $sum_sell['profit_amount'];
                    
                    //$cost_sell = $amount_sell - $Profit_amount_sell;
                    
                    if($Profit_amount_sell > 0){
                        $cost_sell = $amount_sell - $Profit_amount_sell;
                    }
                    else{
                        $cost_sell = $amount_sell;
                    }
                }
                else{
                    $amount_sell = 0;
                    $units_sell = 0;
                    $Profit_amount_sell = 0;
                    $cost_sell = 0;
                }
                

                $cost_nav = $sum_buy['nav'] / $sum_buy['count_list'];
                $cost_nav = Fund::setDecimal4Digit($cost_nav);
                $amount = $sum_buy['amount'];
                $units = $sum_buy['units'];

                //$cost_value = $amount - $cost_sell;
                
                $sum_unit = $units - $units_sell;
                
                $cost_value = $sum_unit * $cost_nav;

                $fund = Fund::findOne($list->fund_id);
                $present_nav = $fund->nav;
                $present_value = $present_nav * $sum_unit;
                $present_value = Fund::setDecimal4Digit($present_value);
                

                $percent = round((($present_value*100/$cost_value)-100), 2);
                
                if($present_value <= 0){
                    $present_value = 0;
                    $percent = 0;
                }
                
                $profit = $present_value-$cost_value;
                
                if($sum_unit <= 0){
                    $sum_unit = 0;
                    $cost_value = 0;
                }

                $list->present_value = $present_value;
                $list->cost_value = $cost_value;
                $list->present_nav = $present_nav;
                $list->cost_nav = $cost_nav;
                $list->units = $sum_unit;
                $list->profit = $profit;
                $list->percent = $percent;
                $list->updated_at = date('Y-m-d H:i:s');
                $list->save();

                //var_dump($sum);exit();
            }

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("
                SELECT SUM(present_value) AS present_value, SUM(cost_value) AS cost_value
                FROM fund_port_list
                WHERE fund_port_id = $port->id
                ");
            $sum = $command->queryOne();

            $sum_cost = $sum['cost_value'];
            $sum_present = $sum['present_value'];
            $port->amount = $sum_cost;
            $port->profit_amount = $sum_present-$sum_cost;
            $port->updated_at = date('Y-m-d H:i:s');
            $port->save();
            foreach ($port_list as $list) {
                $avg = $list->present_value * 100 / $sum_present;
                $list->ratio = $avg;
                $list->save();
            }
            $status = true;
            $transaction->commit();
            
        } catch (\Exception $e) {
            var_dump($e);exit();
            $message = $e;
            $transaction->rollBack();
        }
        
        return ['status' => $status, 'message' => $message];
    }
}