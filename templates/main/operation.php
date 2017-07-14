<?php
/**
 * Created by PhpStorm.
 * User: Gavin Lobo
 * Date: 13/7/17
 * Time: 9:46 AM
 */

class operation extends dbConnection{

    // MAIN function which decode the content from the form, calls post air,send_mail and mysql insert
    public function contact_info(){
        $params = json_decode(file_get_contents('php://input',true));
        $first_name = $this->cleanInputs($params->first_name);
        $last_name = $this->cleanInputs($params->last_name);
        $email = $this->cleanInputs($params->email);
        $question = $this->cleanInputs($params->question);
        $description = $this->cleanInputs($params->description);
        $date = date('Y-m-d H:i:s');

        $this->post_air($first_name,$last_name,$email,$question,$description); //POST values to Airmail table Questions_info
        //response -> {"id":"recMWDAPxp2HhENI5","fields":{"first_name":"Gavin","last_name":"Lobo","email":"gavinandre2007@gmail.com","question_id":6,"questions":"There is a problem with the application","description":"The application keeps crashing"},"createdTime":"2017-07-13T14:42:31.462Z"}

        $result= $this->send_mail('gavin.lobo16@gmail.com','Acknowledgement Receipt Question by Customer Suport Team','Hi The Question has been received by our customer support team. We will get back to you within 24 hours of this acknowledgement. Thank you for a patience. Greetings --- Gallery App');
                        /*{
                "id": "<20170713143521.24626.114C9ACE0A593EBF@sandbox1edc5ed5a5df4ce098a1f9be100380fd.mailgun.org>",
                "message": "Queued. Thank you."
            }*/
            print_r($result);

        // MySQL query to post values from form to database test_db in table contact_info
        $contact_query = mysql_query("INSERT INTO contact_info (first_name,last_name,email,question,description,create_ts) values('$first_name','$last_name','$email','$question','$description','$date')");
        if(mysql_affected_rows()>0){
            $msg[] = "Data Inserted Successfully to MySQL !!!";
            $this->response($this->json($msg), 200);
        }
        else{
            $msg[] = "Something went wrong !!!";
            $this->response($this->json($msg), 500);
        }
    }

    //Mailgun function to send mail to the user
    public function send_mail($email,$subject,$msg) {
        $api_key="key-382bf89eddb189aa7c60f19bf5c91ca1";/* Api Key got from https://mailgun.com/cp/my_account */
        $domain ="sandbox1edc5ed5a5df4ce098a1f9be100380fd.mailgun.org";/* Domain Name you given to Mailgun */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/'.$domain.'/messages');
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'from' => 'Excited Customer <gavinandre2007@gmail.com>',
            'to' => $email,
            'subject' => $subject,
            'html' => $msg
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //Airtable to post the values from the form to the tabel questions_info
    public function post_air($first_name,$last_name,$email,$question,$description){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.airtable.com/v0/appBWUeEz4vfdGNdg/questions_info");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"fields\": {\n  \"first_name\":\"$first_name\",\n  \"last_name\":\"$last_name\",\n  \"email\":\"$email\",\n  \"questions\":\"$question\",\n  \"description\":\"$description\"\n  }\n}");
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = "Authorization: Bearer key83Rznj2Y3Ila5N";
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        else{
            echo $result;
        }
        curl_close ($ch);
    }
}