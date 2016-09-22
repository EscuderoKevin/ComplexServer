<?php
	
	require_once '../../configs/dbconfig.php';
	
	class USER
	{	
		
		private $conn;
		
		public $__port;
		public $__slots;
		
		public $__servername;
		
		public function __construct()
		{
			$database = new Database();
			$db = $database->dbConnection();
			$this->conn = $db;
		}
		
		public function runQuery($sql)
		{
			$stmt = $this->conn->prepare($sql);
			return $stmt;
		}
		
		public function lasdID()
		{
			$stmt = $this->conn->lastInsertId();
			return $stmt;
		}
		
		public function register($uname,$email,$upass,$code)
		{
			try
			{							
				$password = md5($upass);
				$stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,tokenCode) 
				VALUES(:user_name, :user_mail, :user_pass, :active_code)");
				$stmt->bindparam(":user_name",$uname);
				$stmt->bindparam(":user_mail",$email);
				$stmt->bindparam(":user_pass",$password);
				$stmt->bindparam(":active_code",$code);
				$stmt->execute();	
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		public function login($email,$upass)
		{
			try
			{
				$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
				$stmt->execute(array(":email_id"=>$email));
				$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
				
				if($stmt->rowCount() == 1)
				{
					if($userRow['userStatus']=="Y")
					{
						if($userRow['userPass']==md5($upass))
						{
							$_SESSION['userSession'] = $userRow['userID'];
							return true;
						}
						else
						{
							header("Location: index.php?error");
							exit;
						}
					}
					else
					{
						header("Location: index.php?inactive");
						exit;
					}	
				}
				else
				{
					header("Location: index.php?error");
					exit;
				}		
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		
		public function is_logged_in()
		{
			if(isset($_SESSION['userSession']))
			{
				return true;
			}
		}
		
		public function redirect($url)
		{
			header("Location: $url");
		}
		
		public function logout()
		{
			session_destroy();
			$_SESSION['userSession'] = false;
		}
		
		function send_mail($email,$message,$subject)
		{						
			require_once('mailer/class.phpmailer.php');
			$mail = new PHPMailer();
			$mail->IsSMTP(); 
			$mail->SMTPDebug  = 0;                     
			$mail->SMTPAuth   = true;                  
			$mail->SMTPSecure = "ssl";                 
			$mail->Host       = "xxxxxxxxx";      
			$mail->Port       = 465;             
			$mail->AddAddress($email);
			$mail->Username="xxxxxxxx";  
			$mail->Password="xxxxxxxx";            
			$mail->SetFrom('xxxxxx','Verificaction');
			$mail->AddReplyTo("xxxxxxxxxxxxxx","Verificaction");
			$mail->Subject    = $subject;
			$mail->MsgHTML($message);
			$mail->Send();
		}
		
		function subconexts3(){
			require_once('../../configs/settingsts3.php');
			require_once('../../libs/TeamSpeak3/TeamSpeak3.php');
			
			$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userID=:uid");
			$stmt->execute(array(":uid"=>$_SESSION['userSession']));
			$kevin = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$ts3_server = TeamSpeak3::factory("serverquery://".$ts3_user.":".$ts3_pass."@".$ts3_ip.":".$ts3_queryport."");
			$ts3 = $ts3_server->serverGetByPort($kevin['port']);
			$this->__port = $kevin['port'];
			$this->__slots = $kevin['slots'];
			$ts3->execute("clientupdate", array("client_nickname" => $ts3_queryname));
			return $ts3;
		}
		
		function delserver($ts3_ServerInstance){
			
			$ts3_VirtualServer = $ts3_ServerInstance->serverGetByPort($this->__port);
			
			$sid = $ts3_VirtualServer -> getId();
			$ts3 = $ts3_VirtualServer -> getParent();
			if($ts3_VirtualServer -> isOnline()) $ts3_VirtualServer -> Stop();
			if($ts3 -> serverSelectedId() == $sid)
			{
				$ts3 -> serverGetById(0);
			}
			$ts3 -> serverDelete($sid);
		}
		
		function CreateServer($ts3){
			
			
			$this->delserver($ts3);
			
			require_once('../../configs/defaultts3.php');
			
			$this->__servername = $ServerName;
			
			$new_ts3 = $ts3->serverCreate(array(
			"virtualserver_name" => $ServerName,
			"virtualserver_maxclients" => $this->__slots,
			"virtualserver_port" => $this->__port,
			"virtualserver_welcomemessage" => $ServerWelcomeMessage,
			"virtualserver_hostmessage" => $ServerHostMessage,
			"virtualserver_hostbanner_url" => $ServerHostBannerUrl,
			"virtualserver_hostbanner_gfx_url" => $ServerHostBannerGFXULR,
			"virtualserver_hostbanner_gfx_interval" => $ServerHostBannerGFCXInterval,
			"virtualserver_hostbanner_mode" => $ServerHostBannerMode,
			"virtualserver_hostbutton_tooltip" => $ServerHostButtonTooltip,
			"virtualserver_hostbutton_url" => $ServerHostButtonUrl,
			"virtualserver_hostbutton_gfx_url" => $ServerHostButtonGFXURL,
			));
			return $new_ts3;
		}
		
	}																											