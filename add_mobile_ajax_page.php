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
            $category_id = Input::get('category');
            $db = DB::getInstance();
            // mobile unique check...
            $mobile = Input::get('mobile');
            $sql = "SELECT * FROM numbers WHERE number = {$mobile}";
            $getMobile = $db->getAllWithSql($sql);
            if (!$getMobile->count()){
                $insert_mobile = $db->insert('numbers', array(
                    'category_id' => $category_id,
                    'number' => $mobile,
                    'added_by' => Input::get('added_by'),
                    'created_at' => date('Y-m-d H:m:s'),
                ));
                if ($insert_mobile){
                    // get user first name....
                    $user_name = Report::getUserNameById();
                    $user_name = explode(' ', $user_name);
                    $user_name = $user_name[0];

                    // usr mobile for sending..
                    $user_mobile = Report::getUserMobileById();
                    $sender_address = "{$user_name}%0ACell: {$user_mobile}, 01814445932, 029675671%0Awww.iglweb.com%0AIGL Web Ltd.";

                    // category sms for sending..
                    $sms = Report::getCategorySmsById($category_id).'%0A'.$sender_address;
                    $explod_sms = explode(' ', $sms);
                    $sms = implode('%20', $explod_sms);

                    // sender id .......
                    $sender = Report::getCategorySmsSenderById($category_id);

                    $sms_url = ""; // sms api in here ..........................
                    $jsonData['result'] = 'Number successfully added !';
                    $jsonData['total'] = Report::getTotalNumber();
                    $jsonData['today'] = Report::getTotalTodayNumber();
                    $jsonData['success'] = true;
                    file_get_contents($sms_url);

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