 <?php
class Validation
{
	public $_allow = array();
	public $_content_type = "application/json";
	public $_request = array();	
	public $_method = "";		
	public $_code = 200;

//For json response
	public function json($data){
		return json_encode($data,true);
	}

//To validate the inpus 
	public function cleanInputs($data){
	if(empty($data)){
		http_response_code(500);
		$message['error']='Parameter cant be empty';
		echo json_encode($message,true);
		exit();
		}
		$clean_input = (array)$data;
		if(is_array($data)){
			foreach($data as $k => $v){
			$clean_input[$k] = $this->cleanInputs($v);
			}
			}else{
			if(get_magic_quotes_gpc()){
				$data = trim(stripslashes($data));
				}
				$data = strip_tags($data);
				$data = str_replace(array('\'', '"'), '', $data); 
				$clean_input = trim($data);
				}
		return mysql_real_escape_string($clean_input);
	}

//To display responses
	public function response($data,$status) {
			$this->_code = ($status)?$status:200;
			$this->set_headers();
			echo $data;
			unset($data);
			mysql_close($this->db);
			exit;
	}

//To check ststus Code
	public function get_status_message(){
			$status = array(
						100 => 'Continue',  
						101 => 'Switching Protocols',  
						200 => 'OK',
						201 => 'Created',  
						202 => 'Accepted',  
						203 => 'Non-Authoritative Information',  
						204 => 'No Content',  
						205 => 'Reset Content',  
						206 => 'Partial Content',  
						300 => 'Multiple Choices',  
						301 => 'Moved Permanently',  
						302 => 'Found',  
						303 => 'See Other',  
						304 => 'Not Modified',  
						305 => 'Use Proxy',  
						306 => '(Unused)',  
						307 => 'Temporary Redirect',  
						400 => 'Bad Request',  
						401 => 'Unauthorized',  
						402 => 'Payment Required',  
						403 => 'Forbidden',  
						404 => 'Not Found',  
						405 => 'Method Not Allowed',  
						406 => 'Not Acceptable',  
						407 => 'Proxy Authentication Required',  
						408 => 'Request Timeout',  
						409 => 'Conflict',  
						410 => 'Gone',  
						411 => 'Length Required',  
						412 => 'Precondition Failed',  
						413 => 'Request Entity Too Large',  
						414 => 'Request-URI Too Long',  
						415 => 'Unsupported Media Type',  
						416 => 'Requested Range Not Satisfiable',  
						417 => 'Expectation Failed',  
						500 => 'Internal Server Error',  
						501 => 'Not Implemented',  
						502 => 'Bad Gateway',  
						503 => 'Service Unavailable',  
						504 => 'Gateway Timeout',  
						505 => 'HTTP Version Not Supported');
			return ($status[$this->_code])?$status[$this->_code]:$status[500];
		}


	public function set_headers(){
			header("HTTP/1.1 ".$this->_code." ".$this->get_status_message());
			header("Content-Type:".$this->_content_type);
		}

}