

<?php  
header("Content-type: text/html; charset=utf-8");
$appid = "wxfe10b513b25caf7a";  
$secret = "ecfbe8fe6fd20f3ae68d14ff17c8bf9b";  
$code = $_GET["code"];  
$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';  
  
$ch = curl_init();  
curl_setopt($ch,CURLOPT_URL,$get_token_url);  
curl_setopt($ch,CURLOPT_HEADER,0);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );  
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  
$res = curl_exec($ch);  
curl_close($ch);  
$json_obj = json_decode($res,true);  
  
//根据openid和access_token查询用户信息  
$access_token = $json_obj['access_token'];  
$openid = $json_obj['openid'];  
$get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';  
  
$ch = curl_init();  
curl_setopt($ch,CURLOPT_URL,$get_user_info_url);  
curl_setopt($ch,CURLOPT_HEADER,0);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );  
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  
$res = curl_exec($ch);  
curl_close($ch);  
  
//解析json  
$user_obj = json_decode($res,true);  
$_SESSION['user'] = $user_obj;  
//print_r($user_obj);  
//echo json_encode($user_obj,JSON_UNESCAPED_UNICODE);
$openid=$user_obj['openid'];
//$openid='dusfhusdfhkjr748';

$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "bitoa";
 
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
 mysqli_set_charset($conn,"utf8");
$sql = "SELECT id,username FROM course WHERE openid='$openid' ";
$result = $conn->query($sql);
 
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
    	$xm=$row['username'];
    	$xh=$row['id'];
        $re=array(
        	"xm"=>$xm,
        	"xh"=>$xh,
        	"openid"=>$openid
        	);
        echo json_encode($re,JSON_UNESCAPED_UNICODE);
    }
} else {
	$re=array(
        	
        	"code"=>401,
        	"openid"=>$openid
        	);
    echo json_encode($re,JSON_UNESCAPED_UNICODE);
}
$conn->close();


  
