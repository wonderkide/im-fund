<?php

namespace app\components;

use Yii;
use app\components\SSP;
use yii\db\mssql\PDO;
use app\models\Transaction;

class DatatablesProcessing {
    
    public function prosessing_data( $request, $table, $primaryKey, $columns){
        $bindings = array();
        $select = $this->get_select($columns);
        $limit = $this->get_limit($request, $columns);
        $order = $this->get_order($request, $columns);
        $where = $this->get_where($request, $columns, $bindings);
        $data = $this->get_data($select, $table, $where, $order, $limit);
        $recordsFiltered = $this->get_count_filter($table, $where);
        $recordsTotal = $this->get_count_total($table, $primaryKey);
        
        $result = array(
                "draw"            => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                "recordsTotal"    => intval( $recordsTotal ),
                "recordsFiltered" => intval( $recordsFiltered ),
                "data"            => SSP::data_output( $columns, $data )
        );
        
        return $result;
    }
    
    public function processing_data_by_sql($request, $table, $data_select, $count_select, $from, $where, $order, $columns, $join = null, $replace_join = null){
        if($where != ''){
            $where = 'WHERE ' . $where;
        }
        if($join){
            $where = $join . $where;
        }
        
        $bindings = array();
        $limit = $this->get_limit($request, $columns);
        $check_order = $this->get_order_by_sql($request, $columns);
        if($check_order){
            $order = $check_order;
        }
        $and_where = $this->filter_by_sql($request, $table, $columns, $bindings, $replace_join);
        //var_dump($bindings);exit();
        $data = $this->get_data_by_sql($data_select, $from, $where, $and_where, $order, $limit, $bindings);
        $recordsFiltered = $this->get_count_filter_by_sql($count_select, $from, $where, $and_where);
        $recordsTotal = $this->get_count_total_by_sql($count_select, $from, $where);
        //$recordsTotal = $recordsFiltered;
        
        $result = array(
                "draw"            => isset ( $request['draw'] ) ?
                        intval( $request['draw'] ) :
                        0,
                "recordsTotal"    => intval( $recordsTotal ),
                "recordsFiltered" => intval( $recordsFiltered ),
                "data"            => $this->data_output_by_sql( $columns, $data )
        );
        
        return $result;
    }
    
    public function generate_manage_button($array){
        $html = '';
        foreach ($array as $value) {
            $btn_class = $value['btn_class'];
            $title = $value['title'];
            $id = $value['id'];
            $url = $value['url'];
            $data_title = $value['data_title'];
            $icon_class = $value['fa fa-pencil-alt'];
            $text = '<button type="button" class="btn btn-ssm btn-secondary activity-manage-link" title="แก้ไขข้อมูลรายการ" data-id="8" data-url="/transaction/edit" data-title="แก้ไขข้อมูลรายการ"><i class="fa fa-pencil-alt"></i></button>';
            
            $html .= $text;
        }
        return $html;
    }
    
    protected function get_select($columns) {
        $select = "`".implode("`, `", SSP::pluck($columns, 'db'))."`";
        return $select;
    }
    protected function get_limit($request, $columns) {
        $limit = SSP::limit( $request, $columns );
        return $limit;
    }
    protected function get_order($request, $columns) {
        $order = SSP::order( $request, $columns );
        return $order;
    }
    protected function get_where($request, $columns, $bindings) {
        $where = SSP::filter( $request, $columns, $bindings );
        return $where;
    }
    protected function get_data($select, $table, $where, $order, $limit) {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
            SELECT $select
            FROM $table
            $where
            $order
            $limit");
        $data = $command->queryAll();
        return $data;
    }
    protected function get_count_filter($table, $where) {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
                SELECT COUNT(`id`)
                FROM `$table`
                $where");
        $resFilterLength = $command->queryAll();
        $recordsFiltered = $resFilterLength[0]["COUNT(`id`)"];
        return $recordsFiltered;
    }
    protected function get_count_total($table, $primaryKey) {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
                SELECT COUNT(`{$primaryKey}`)
                FROM `$table`
                ");
        $resTotalLength = $command->queryAll();
        $recordsTotal = $resTotalLength[0]["COUNT(`{$primaryKey}`)"];
        return $recordsTotal;
    }
    protected function get_data_by_sql($select, $from, $where, $and_where, $order, $limit, $bindings) {
        if($and_where != ''){
            if($where == ''){
                $where = 'WHERE ' . $and_where;
            }
            else{
                $where .= ' AND '.$and_where;
            }
        }
        
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
            SELECT $select
            FROM $from
            $where
            ORDER BY $order
            $limit");
        /*if ( is_array( $bindings ) ) {
            for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
                $binding = $bindings[$i];
                $command->bindValue( $binding['key'], $binding['val'], 1 );
            }
        }*/
     //var_dump($command);exit();
        $data = $command->queryAll();
        return $data;
    }
    protected function get_count_filter_by_sql($select, $from, $where, $and_where) {
        if($and_where != ''){
            if($where == ''){
                $where = 'WHERE ' . $and_where;
            }
            else{
                $where .= ' AND '.$and_where;
            }
        }
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
                SELECT $select
                FROM $from
                $where");
        $resFilterLength = $command->queryAll();
        $recordsFiltered = $resFilterLength[0]["id"];
        return $recordsFiltered;
    }
    protected function get_count_total_by_sql($select, $from, $where) {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
                SELECT $select
                FROM $from
                $where");
        $resTotalLength = $command->queryAll();
        $recordsTotal = $resTotalLength[0]["id"];
        return $recordsTotal;
    }
    
    protected function data_output_by_sql ( $columns, $data )
    {
        $out = array();

        for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
            $row = array();

            for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
                $column = $columns[$j];

                // Is there a formatter?
                if ( isset( $column['formatter'] ) ) {
                    if(empty($column['db'])){
                        $row[ $column['dt'] ] = $column['formatter']( $data[$i] );
                    }
                    else{
                        if($column['db'] == 'key'){
                            $row[ $column['dt'] ] = $column['formatter']( $i+1, $data[$i] );
                        }else{
                            $row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
                        }
                    }
                }
                else {
                    
                    if(!empty($column['db'])){
                        if($column['db'] == 'key'){
                            $row[ $column['dt'] ] = $i+1;
                        }else{
                            $row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
                        }
                    }
                    else{
                        $row[ $column['dt'] ] = "";
                    }
                }
            }

            $out[] = $row;
        }

        return $out;
    }
    
    protected function filter_by_sql ( $request, $table, $columns, &$bindings, $replace_join )
    {
            $globalSearch = array();
            $columnSearch = array();
            $dtColumns = SSP::pluck( $columns, 'dt' );

            if ( isset($request['search']) && $request['search']['value'] != '' ) {
                    $str = $request['search']['value'];
                    $store_str = $str;
                    for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
                            $requestColumn = $request['columns'][$i];
                            $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                            $column = $columns[ $columnIdx ];

                            if ( $requestColumn['searchable'] == 'true' ) {
                                    if(!empty($column['db'])){
                                            
                                            if(!isset($column['searching']) || $column['searching']){
                                                if(isset($column['filter_function'])){
                                                    $fnc = $column['filter_function'];
                                                    $str = $this->$fnc($str);
                                                }
                                                else{
                                                    $str = $store_str;
                                                }
                                                if(is_array($str)){
                                                    foreach ($str as $value) {
                                                        if(isset($column['search_table'])){
                                                            $globalSearch[] = $column['search_table'].".".$column['db']." LIKE '%$value%'";
                                                        }
                                                        else{
                                                            $globalSearch[] = $table.".".$column['db']." LIKE '%$value%'";
                                                        }
                                                    }
                                                }else{
                                                
                                                    if(isset($column['search_table'])){
                                                        $globalSearch[] = $column['search_table'].".".$column['db']." LIKE '%$str%'";
                                                    }
                                                    else{
                                                        $globalSearch[] = $table.".".$column['db']." LIKE '%$str%'";
                                                    }
                                                }
                                            }
                                            //$binding = SSP::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
                                            //$globalSearch[] = "`".$column['db']."` LIKE ".$binding;
                                    }
                            }
                    }
            }
            //var_dump($globalSearch);exit();
            

            // Individual column filtering
            if ( isset( $request['columns'] ) ) {
                    for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
                            $requestColumn = $request['columns'][$i];
                            $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                            $column = $columns[ $columnIdx ];

                            $str = $requestColumn['search']['value'];

                            if ( $requestColumn['searchable'] == 'true' &&
                             $str != '' ) {
                                    if(!empty($column['db'])){
                                            if(!isset($column['searching']) || $column['searching']){
                                                if(isset($column['filter_function'])){
                                                    $fnc = $column['filter_function'];
                                                    $str = $this->$fnc($str);
                                                }
                                                if(is_array($str)){
                                                    foreach ($str as $value) {
                                                        if(isset($column['search_table'])){
                                                            $globalSearch[] = $column['search_table'].".".$column['db']." LIKE '%$value%'";
                                                        }
                                                        else{
                                                            $globalSearch[] = $table.".".$column['db']." LIKE '%$value%'";
                                                        }
                                                    }
                                                }else{
                                                    if(isset($column['search_table'])){
                                                        $columnSearch[] = $column['search_table'].".".$column['db']." LIKE '%$str%'";
                                                    }
                                                    else{
                                                        $columnSearch[] = $table.".".$column['db']." LIKE '%$str%'";
                                                    }
                                                }
                                            }
                                            /*if($column['db'] == 'ufa_username'){
                                                var_dump($str);exit();
                                            }*/
                                            //$binding = SSP::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
                                            //$columnSearch[] = "`".$column['db']."` LIKE ".$binding;
                                    }
                            }
                    }
            }

            // Combine the filters into a single string
            $where = '';
            //var_dump($columnSearch);exit();

            if ( count( $globalSearch ) ) {
                    $where = '('.implode(' OR ', $globalSearch).')';
            }

            if ( count( $columnSearch ) ) {
                    $where = $where === '' ?
                            implode(' AND ', $columnSearch) :
                            $where .' AND '. implode(' AND ', $columnSearch);
            }

            /*if ( $where !== '' ) {
                    $where = 'WHERE '.$where;
            }*/
            
            //replace join table
            //$where = str_replace('bank_transfer.ufa_username', 'member.ufa_username', $where);
            //$where = str_replace('game_member_access.username', 'member.username', $where);
            //$where = str_replace('game_member_access.title', 'game.title', $where);
            //replace join table
            if($replace_join){
                foreach ($replace_join as $replace_row) {
                    $where = str_replace($replace_row['from'], $replace_row['to'], $where);
                }
            }
            
            return $where;
    }
    
    public function get_order_by_sql ( $request, $columns )
    {
            $order = '';

            if ( isset($request['order']) && count($request['order']) ) {
                    $orderBy = array();
                    $dtColumns = SSP::pluck( $columns, 'dt' );

                    for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
                            // Convert the column index into the column data property
                            $columnIdx = intval($request['order'][$i]['column']);
                            $requestColumn = $request['columns'][$columnIdx];

                            $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                            $column = $columns[ $columnIdx ];

                            if ( $requestColumn['orderable'] == 'true' ) {
                                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                                            'ASC' :
                                            'DESC';
                                    
                                    if(isset($column['order_column'])){
                                        $col = $column['order_column'];
                                        if(isset($column['order_swap']) && $column['order_swap']){
                                            if($dir == 'ASC'){
                                                $dir = 'DESC';
                                            }
                                            else{
                                                $dir = 'ASC';
                                            }
                                        }
                                    }
                                    else{
                                        $col = $column['db'];
                                    }

                                    $orderBy[] = '`'.$col.'` '.$dir;
                            }
                    }

                    if ( count( $orderBy ) ) {
                            $order = ''.implode(', ', $orderBy);
                    }
            }

            return $order;
    }
    
    protected function filter_transaction_type($text) {
        $arr = Transaction::getTransactionTypeAll();
        $index = [];
        foreach ($arr as $key => $value) {
            if(strpos($value, $text) !== false){
                array_push($index, $key);
            }
        }

        return $index;
        
    }
    protected function filter_statement_status($text){
        $arr = [
            'ยังไม่ใช้', 'ใช้แล้ว'
        ];
        $index = [];
        foreach ($arr as $key => $value) {
            if(strpos($value, $text) !== false){
                array_push($index, $key);
            }
        }
        return $index;
    }
    protected function filter_transaction_status($text) {
        $arr = Transaction::getTransactionStatusAll();
        //$input = preg_quote($text, '~'); // don't forget to quote input string!
        //$result = preg_grep('~' . $input . '~', $arr);
        //var_dump($result);exit();
        
        
        //$index = array_search($text,$arr);
        //if($index !== false){
        //    return $index;
        //}
        $index = [];
        foreach ($arr as $key => $value) {
            if(strpos($value, $text) !== false){
                array_push($index, $key);
            }
        }
        return $index;
    }
    protected function filter_bank_transfer_status($text) {
        $arr = \app\models\BankTransfer::getBankTransferStatusAll();
        $index = [];
        foreach ($arr as $key => $value) {
            if(strpos($value, $text) !== false){
                array_push($index, $key);
            }
        }
        return $index;
    }
    
    protected function filter_game_access_status($text) {
        $arr = [0 => 'ปิด', 1 => 'เปิด'];
        $index = [];
        foreach ($arr as $key => $value) {
            if(strpos($value, $text) !== false){
                array_push($index, $key);
            }
        }
        return $index;
    }
    
    protected function filter_game_ticket_type($text) {
        $arr = [-1 => 'ถอนเครดิค',0 => 'ของรางวัล', 1 => 'เงินรางวัล'];
        $index = [];
        foreach ($arr as $key => $value) {
            if(strpos($value, $text) !== false){
                array_push($index, $key);
            }
        }
        return $index;
    }
    
    protected function filter_winlose_status($text) {
        $arr = \app\models\WinLose::getWinloseStatus();
        $index = [];
        foreach ($arr as $key => $value) {
            if(strpos($value, $text) !== false){
                array_push($index, $key);
            }
        }
        return $index;
    }
    
}