<?php
namespace common\components;

use Yii;
use yii\base\Component;
use common\models\FundPortList;
use common\models\Fund;
use common\models\FundPortListDetail;

class CalculateService extends Component {
    
    /*public function calculatePort($port){
        
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
    
    public function calculatePortByStatus($port){
        
        $status = false;
        $message = '';
        
        $transaction = Yii::$app->db->beginTransaction();
        try {
        
            $port_list = FundPortList::find()->where(['fund_port_id' => $port->id])->all();
            
            foreach ($port_list as $list) {
                $details = FundPortListDetail::find()->where(['fund_port_list_id' => $list->id, 'calculate' => 0, 'status' => 1])->orderBy(['date' => SORT_ASC])->all();
                
                
                
                if($details){
                    
                    $list_present_value = $list->present_value;
                    $list_cost_value = $list->cost_value;
                    $list_present_nav = $list->present_nav;
                    $list_cost_nav = $list->cost_nav;
                    $list_units = $list->units;
                    $list_profit= $list->profit;
                    
                    $fund = Fund::findOne($list->fund_id);
                    $present_nav = $fund->nav;
                    
                    foreach ($details as $detail) {
                        
                        if($detail->type == 1){
                            if($list_units <= 0){
                                $cost_nav = $detail->nav;
                                $cost_value = $detail->amount;
                            }
                            else{
                                $cost_nav = ($detail->nav + $list_cost_nav) / 2;
                                $cost_nav = Fund::setDecimal4Digit($cost_nav);
                                $cost_value = $list_cost_value + $detail->amount;
                            }
                            
                            $sum_unit = $list_units + $detail->units;

                            $present_value = $present_nav * $sum_unit;
                            $present_value = Fund::setDecimal4Digit($present_value);

                            $profit = $present_value-$cost_value;
                            $percent = round((($present_value*100/$cost_value)-100), 2);
                            
                            $realized = 0;

                        }
                        elseif($detail->type == 2){
                            if($list_units <= 0){
                                $detail->calculate = 1;
                                $detail->save();
                                
                                continue;
                            }
                            $sum_unit = $list_units - $detail->units;
                            if($sum_unit < 1){
                                
                                $present_value = $present_nav * $sum_unit;
                                $present_value = Fund::setDecimal4Digit($present_value);
                                
                                $cost_value = $sum_unit * $detail->nav;
                                
                                $realized = $cost_value - $present_value;
                                $realized = Fund::setDecimal4Digit($realized);
                                
                                $cost_nav = 0;
                                $sum_unit = 0;
                                $cost_value = 0;
                                $present_value = 0;
                                $percent = 0;
                                
                                $profit = 0;
                            }
                            else{
                                //$cost_nav = ($detail->nav + $list_cost_nav) / 2;
                                //$cost_nav = Fund::setDecimal4Digit($cost_nav);
                                
                                $amount_sell = $detail->amount;
                                $units_sell = $detail->units;
                                $Profit_amount_sell = $detail->profit_amount;
                                
                                //$detail_nav = $detail->nav;
                                
                                $cost_nav = $list->cost_nav;
                                $amount = $sum_unit * $cost_nav;
                                //$cost_value = $list_cost_value - $detail->amount;
                                
                                $cost_sell = $amount_sell - $Profit_amount_sell;
                                
                                $present_value = $present_nav * $sum_unit;
                                $present_value = Fund::setDecimal4Digit($present_value);
                                
                                
                                //$realized = $cost_value - $present_value;
                                //$realized = Fund::setDecimal4Digit($realized);
                                
                                $realized = $Profit_amount_sell;
                                
                                $cost_value = $amount - $cost_sell;
                                $profit = $present_value - $cost_value;
                                
                                $percent = round((($present_value*100/$cost_value)-100), 2);
                                
                            }
                        }
                        
                        $port_realized = $list->realized + $realized;
                        
                        $list->present_value = $present_value;
                        $list->cost_value = $cost_value;
                        $list->present_nav = $present_nav;
                        $list->cost_nav = $cost_nav;
                        $list->units = $sum_unit;
                        $list->profit = $profit;
                        $list->percent = $percent;
                        $list->realized = $port_realized;
                        $list->updated_at = date('Y-m-d H:i:s');
                        $list->save();

                        $detail->calculate = 1;
                        $detail->save();
                    }
                }
                
            }

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("
                SELECT SUM(present_value) AS present_value, SUM(cost_value) AS cost_value, SUM(realized) AS realized
                FROM fund_port_list
                WHERE fund_port_id = $port->id
                ");
            $sum = $command->queryOne();

            $sum_cost = $sum['cost_value'];
            $sum_present = $sum['present_value'];
            $sum_realized = $sum['realized'];
            $port->amount = $sum_cost;
            $port->profit_amount = $sum_present-$sum_cost;
            $port->realized = $sum_realized;
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
    }*/
    
    public function calculatePortAll($port, $all = false){
        
        $status = false;
        $message = '';
        
        $transaction = Yii::$app->db->beginTransaction();
        try {
        
            $port_list = FundPortList::find()->where(['fund_port_id' => $port->id])->all();
            
            foreach ($port_list as $list) {
                //$details = FundPortListDetail::find()->where(['fund_port_list_id' => $list->id, 'status' => 1, 'calculate' => $cal])->orderBy(['date' => SORT_ASC])->all();
                
                //var_dump($details);exit();
                
                if($all){
                    
                    $details = FundPortListDetail::find()->where(['fund_port_list_id' => $list->id, 'status' => 1])->orderBy(['date' => SORT_ASC])->all();
                
                    $list->present_value = 0;
                    $list->cost_value = 0;
                    $list->present_nav = 0;
                    $list->cost_nav = 0;
                    $list->units = 0;
                    $list->profit = 0;
                    $list->percent = 0;
                    $list->profit = 0;
                    $list->ratio = 0;
                    $list->realized = 0;

                    $list->save();
                }
                else{
                    $details = FundPortListDetail::find()->where(['fund_port_list_id' => $list->id, 'status' => 1, 'calculate' => 0])->orderBy(['date' => SORT_ASC])->all();
                }
                
                if($details){
                    
                    $list_present_value = $list->present_value;
                    $list_cost_value = $list->cost_value;
                    $list_present_nav = $list->present_nav;
                    $list_cost_nav = $list->cost_nav;
                    $list_units = $list->units;
                    $list_profit= $list->profit;
                    
                    $fund = Fund::findOne($list->fund_id);
                    $present_nav = $fund->nav;
                    
                    foreach ($details as $detail) {
                        
                        if($detail->type == 1){
                            if($list_units <= 0){
                                $cost_nav = $detail->nav;
                                $cost_value = $detail->amount;
                            }
                            else{
                                $cost_nav = ($detail->nav + $list_cost_nav) / 2;
                                $cost_nav = Fund::setDecimal4Digit($cost_nav);
                                $cost_value = $list_cost_value + $detail->amount;
                            }
                            
                            $sum_unit = $list_units + $detail->units;

                            $present_value = $present_nav * $sum_unit;
                            $present_value = Fund::setDecimal4Digit($present_value);

                            $profit = $present_value-$cost_value;
                            $percent = round((($present_value*100/$cost_value)-100), 2);
                            
                            $realized = 0;

                        }
                        elseif($detail->type == 2){
                            if($list_units <= 0){
                                $detail->calculate = 1;
                                $detail->save();
                                
                                continue;
                            }
                            $sum_unit = $list_units - $detail->units;
                            if($sum_unit < 1){
                                
                                $present_value = $present_nav * $sum_unit;
                                $present_value = Fund::setDecimal4Digit($present_value);
                                
                                $cost_value = $sum_unit * $detail->nav;
                                
                                $realized = $cost_value - $present_value;
                                $realized = Fund::setDecimal4Digit($realized);
                                
                                $cost_nav = 0;
                                $sum_unit = 0;
                                $cost_value = 0;
                                $present_value = 0;
                                $percent = 0;
                                
                                $profit = 0;
                            }
                            else{
                                //$cost_nav = ($detail->nav + $list_cost_nav) / 2;
                                //$cost_nav = Fund::setDecimal4Digit($cost_nav);
                                
                                $amount_sell = $detail->amount;
                                $units_sell = $detail->units;
                                $Profit_amount_sell = $detail->profit_amount;
                                
                                //$detail_nav = $detail->nav;
                                
                                $cost_nav_cal = $list->cost_nav;
                                
                                $cost_nav = $list_cost_nav;
                                $amount = $sum_unit * $cost_nav_cal;
                                //$cost_value = $list_cost_value - $detail->amount;
                                
                                $cost_sell = $amount_sell - $Profit_amount_sell;
                                
                                $present_value = $present_nav * $sum_unit;
                                $present_value = Fund::setDecimal4Digit($present_value);
                                
                                
                                //$realized = $cost_value - $present_value;
                                //$realized = Fund::setDecimal4Digit($realized);
                                
                                $realized = $Profit_amount_sell;
                                
                                $cost_value = $amount - $Profit_amount_sell;
                                $profit = $present_value - $cost_value;
                                
                                $percent = round((($present_value*100/$cost_value)-100), 2);
                                
                            }
                        }
                        
                        $port_realized = $list->realized + $realized;
                        
                        $list->present_value = $present_value;
                        $list->cost_value = $cost_value;
                        $list->present_nav = $present_nav;
                        $list->cost_nav = $cost_nav;
                        $list->units = $sum_unit;
                        $list->profit = $profit;
                        $list->percent = $percent;
                        $list->realized = $port_realized;
                        $list->updated_at = date('Y-m-d H:i:s');
                        $list->save();
                        
                        $list_present_value = $present_value;
                        $list_cost_value = $cost_value;
                        $list_present_nav = $present_nav;
                        $list_cost_nav = $cost_nav;
                        $list_units = $sum_unit;
                        $list_profit = $profit;

                        $detail->calculate = 1;
                        $detail->save();
                    }
                }
                
            }

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("
                SELECT SUM(present_value) AS present_value, SUM(cost_value) AS cost_value, SUM(realized) AS realized
                FROM fund_port_list
                WHERE fund_port_id = $port->id
                ");
            $sum = $command->queryOne();

            $sum_cost = $sum['cost_value'];
            $sum_present = $sum['present_value'];
            $sum_realized = $sum['realized'];
            $port->amount = $sum_cost;
            $port->profit_amount = $sum_present-$sum_cost;
            $port->realized = $sum_realized;
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