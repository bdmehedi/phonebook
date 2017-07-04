<?php
//header('Content-type: text/javascript');
require_once "core/init.php";
$jsonData = array(
    'success' => 0,
    'result' => '',
    'total' => 0,
    'today' => 0,
);
if (Input::exists()){
    if (Input::get('token')){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'mobile' => array('required' => true),
            'category' => array('required' => true),
            'added_by' => array('required' => true),
        ));

        if ($validate->passed()){
            //$jsonData['result'] = 'validate passed !';
            $db = DB::getInstance();
            // mobile unique check...
            $mobile = Input::get('mobile');
            $sql = "SELECT * FROM numbers WHERE number = {$mobile}";
            $getMobile = $db->getAllWithSql($sql);
            if (!$getMobile->count()){
                $insert_mobile = $db->insert('numbers', array(
                    'category_id' => Input::get('category'),
                    'number' => Input::get('mobile'),
                    'added_by' => Input::get('added_by'),
                    'created_at' => date('Y-m-d H:m:s'),
                ));
                if ($insert_mobile){
                    $jsonData['result'] = 'Number successfully added !';
                    $jsonData['total'] = Report::getTotalNumber();
                    $jsonData['today'] = Report::getTotalTodayNumber();
                    $jsonData['success'] = true;
                }else {
                    $jsonData['result'] = 'Opps, Something going wrong !';
                }
            }else{
                $jsonData['result'] = "Opps, already added this.";
            }
        }else{
            foreach ($validate->errors() as $error) {
                $jsonData['result'] = $jsonData['result'] . $error . '! ';
            }
        }
    }else {

    }
}else{
    $jsonData['result'] = 'Input not found !';
}


echo json_encode($jsonData);