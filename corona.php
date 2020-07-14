<?php
$API_KEY =""; # YOUR BOT API_KEY .
define("API_KEY",$API_KEY); # DEFINE THE API_KEY AS API_KEY TO USE IT INSIDE FUNCTION
function bot($method,$datas=[]){
if(function_exists('curl_init')){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch  = curl_init();
curl_setopt($ch,CURLOPT_URL,$url); curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
} # END OF ISSET CURL
}else{
echo file_get_contents("https://api.telegram.org/bot" . API_KEY . "/setwebhook?url=" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME']);
$iBadlz = http_build_query($datas);
$url = "https://api.telegram.org/bot".API_KEY."/".$method."?$iBadlz";
$iBadlz = file_get_contents($url);
return json_decode($iBadlz);
} # END OF !CURL EXISTS
}
#Function
function SendMsg($chat_id,$text,$parse_mode,$disable_web_page_preview,$reply_markup,$message_id){ //SendMessage
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$text,
'parse_mode'=>$parse_mode,
'disable_web_page_preview'=>$disable_web_page_preview,
'reply_markup'=>$reply_markup,
'reply_to_message_id'=>$message_id,
]);
}
function EditMsg($chat_id,$message_id,$text,$parse_mode,$disable_web_page_preview,$reply_markup){
bot('editMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>$text,
'parse_mode'=>$parse_mode,
'disable_web_page_preview'=>$disable_web_page_preview,
'reply_markup'=>$reply_markup
]);
}
function DelMsg($chat_id,$message_id){ //DeleteMessage
bot('deletemessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id
]);
}
function Answer($chat_id,$text,$show_alert){ //answercallbackquery
bot('answercallbackquery',[
'callback_query_id'=>$chat_id,
'text'=>$text,
'show_alert'=>$show_alert,
]);
}
function ForMsg($chat_id,$from_id,$message_id){
bot('forwardMessage',[
'chat_id'=>$chat_id,
'from_chat_id'=>$from_id,
'message_id'=>$message_id,
]);
}
 #End Function
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$text = $message->text;
$chat_id2 = $update->callback_query->message->chat->id;
$message_id2 = $update->callback_query->message->message_id;
$data = $update->callback_query->data;
$from_id = $message->from->id;
$name = $message->from->first_name;
$message_id = $message->message_id;
$answer_id = $update->callback_query->id;
$start = file_get_contents("start.txt");
$admin = "543150537";
$Channel = "Api_File_Code"; // معرف قناتك بدون  ل @
$k = json_encode(['inline_keyboard' => [ //keyboard #
[['text'=>'Me Channel 🦠.','url' =>"t.me/".$Channel]]
],
]);
$join = file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@".$Channel."&user_id=".$from_id); //Join Channel
if($message && (strpos($join,'"status":"left"') or strpos($join,'"Bad Request: USER_ID_INVALID"') or strpos($join,'"status":"kicked"'))!== false){
$caption_join = 'مرحبا بك عزيزي ،🦠.'.PHP_EOL.'لستخدام البوت عليك الاشتراك في قناة البوت ،🦠.'.PHP_EOL.'قناة البوت : '.'@'.$Channel.'،🦠.'.PHP_EOL.'ان قمت بالاشتراك في قناة البوت ارسل /start مجددا ،🦠.';
SendMsg($chat_id,$caption_join,null,True,$k,$message_id);return false;}
$caption_start = '🦠| مرحبا بك عزيزي.'.$name.PHP_EOL.'🦠| في بوت احصائيات فايروس كورونا'.PHP_EOL.'🦠| يمكنك من خلال البوت الطلاع على احصائيات كورونا حلو العالك'.PHP_EOL.'🦠| من فضلك قم برسال كلمةه ، /corona';
if($text == "/start"){ //Start 
if($start == null){
SendMsg($chat_id,$caption_start,"Markdown",True,$k,$message_id);
}elseif($start != null){
SendMsg($chat_id,$start,"Markdown",True,$k,$message_id);}}
if($text == "/corona"){
$reply_markup = [];
$reply_markup['inline_keyboard'][] = [['text'=>'الدولةه.','callback_data'=>'s'],['text'=>'المصابين.','callback_data'=>'s'],['text'=>'الاموات.','callback_data'=>'s']];
$Api = json_decode(file_get_contents("https://alshphp.cf/All_Api/corona/?Cor=corona"), true);
for($b =0; $b <= 30; $b++){
$reply_markup['inline_keyboard'][] = [['text'=>$Api['result']['Cor'][$b]['Country'],'callback_data'=>'a#'.$b],['text'=>$Api['result']['Cor'][$b]['Cases'],'callback_data'=>'a#'.$b],['text'=>$Api['result']['Cor'][$b]['Death'].' ('.$Api['result']['Cor'][$b]['Death_per'].')','callback_data'=>'a#'.$b]];}
$reply_markup['inline_keyboard'][] = [['text'=>'التالي. ','callback_data'=>'p-30']];
$reply_markup = json_encode($reply_markup);
SendMsg($chat_id,"- عزيزي اليك احصائيات المصابين بكورونا ، 🦠.".PHP_EOL."- لرجوع ارسل - /corona من فضلك ، 🦠.","Markdown",True,$reply_markup,$message_id);}
$ex_ = explode('#',$data); 
if($data == "a#$ex_[1]"){ 
$Api = json_decode(file_get_contents("https://alshphp.cf/All_Api/corona/?Cor=corona"), true);
$caption_answer = '• الدولةه : '.$Api['result']['Cor'][$ex_[1]]['Country'].PHP_EOL.'• المصابين : '.$Api['result']['Cor'][$ex_[1]]['Cases'].PHP_EOL.'• المتوفين : '.$Api['result']['Cor'][$ex_[1]]['Death'].' (%'.$Api['result']['Cor'][$ex_[1]]['Death_per'].')';
Answer($answer_id,$caption_answer,True);}
$ex = explode('-',$data);
if($data = "p-$ex[1]"){
$n = 30+$ex[1];
$reply_markup = [];
$reply_markup['inline_keyboard'][] = [['text'=>'الدولةه.','callback_data'=>'s'],['text'=>'المصابين.','callback_data'=>'s'],['text'=>'الاموات.','callback_data'=>'s']];
$Api = json_decode(file_get_contents("https://alshphp.cf/All_Api/corona/?Cor=corona"), true);
for($b =$ex[1]; $b <= $n; $b++){
$reply_markup['inline_keyboard'][] = [['text'=>$Api['result']['Cor'][$b]['Country'],'callback_data'=>'a#'.$b],['text'=>$Api['result']['Cor'][$b]['Cases'],'callback_data'=>'a#'.$b],['text'=>$Api['result']['Cor'][$b]['Death'].' ('.$Api['result']['Cor'][$b]['Death_per'].')','callback_data'=>'a#'.$b]];}
$reply_markup['inline_keyboard'][] = [['text'=>'التالي. ','callback_data'=>'p-'.$n]];
$reply_markup = json_encode($reply_markup);
EditMsg($chat_id2,$message_id2,"- عزيزي اليك احصائيات المصابين بكورونا ، 🦠.".PHP_EOL."- لرجوع ارسل - /corona من فضلك ، 🦠.","Markdown",True,$reply_markup);}
$kb = json_encode(['keyboard' => [ //keyboard 1 #
[['text'=>'اذاعةه ، 💘'],['text'=>'عدد الاعضاء ، 💭']],
[['text'=>'اذاعةه بالتوجيه ، 📛.']], 
[['text'=>'وضع رسالةه ستارت ، ☁.']],
],
'resize_keyboard'=>true,
]);
$k_b = json_encode(['keyboard' => [ //keyboard 2 #
[['text'=>'الغاء الامر ، 🎈']],
],
'resize_keyboard'=>true,
]);
$user_id = explode("\n",file_get_contents("Member.txt"));
$count = count($user_id)-1;
$bc = file_get_contents("bc.txt");
if ($update && !in_array($from_id, $user_id)) {
file_put_contents("Member.txt", $from_id."\n",FILE_APPEND);}
$caption_bc = 'مرحبا بك عزيزي المطور ، 💘.'.PHP_EOL.'اليك الاوامر الخاصةه بك ، 💭.'.PHP_EOL.'اختر من الكيبورد الذي فل الاسفل ،📛.';
if($text == "/start" and $from_id == $admin){ //Start 
SendMsg($chat_id,$caption_bc,"Markdown",True,$kb,$message_id);}
if($message and $text != "الغاء الامر ، 🎈" and $bc == "yes" and $from_id == $admin){
for ($i=0; $i < count($user_id); $i++) { 
SendMsg($user_id[$i],$text,null,True,null,null); unlink("bc.txt"); }
SendMsg($admin,"• تم ارسال رسالتك عزيزي.",null,True,$kb,$message_id); unlink("bc.txt");}
if($text == "عدد الاعضاء ، 💭" and $from_id == $admin){
SendMsg($admin,"عدد اعضاء البوت ، *$count* 📛. ","Markdown",True,$kb,$message_id);}
if($text == "اذاعةه ، 💘" and $from_id == $admin){
file_put_contents("bc.txt","yes");
SendMsg($admin,"ارسل رسالتك الان عزيزي ، 🎄.","Markdown",True,$k_b,$message_id);}
if($text == "الغاء الامر ، 🎈" and $from_id == $admin){
SendMsg($admin,"تم الغاء الارسال عزيزي ، 📥.","Markdown",True,$kb,$message_id); unlink("bc.txt");}
if($message and $text != "الغاء الامر ، 🎈" and $bc == "for" and $from_id == $admin){
for ($i=0; $i < count($user_id); $i++) { 
ForMsg($user_id[$i],$chat_id,$message_id); unlink("bc.txt");}
SendMsg($admin,"• تم ارسال توجيه عزيزي.",null,True,$kb,$message_id); unlink("bc.txt");}
if($text == "اذاعةه بالتوجيه ، 📛." and $from_id == $admin){
file_put_contents("bc.txt","for");
SendMsg($admin,"ارسل رسالتك لكي اقوم بتوجيهه ، 📮.","Markdown",True,$k_b,$message_id);}
if($text == "وضع رسالةه ستارت ، ☁." and $from_id == $admin){
file_put_contents("bc.txt","start");
SendMsg($admin,"ارسل رسالة الاستارت من فضلك ، 💰.","Markdown",True,$k_b,$message_id);}
if($text and $text != "وضع رسالةه ستارت ، ☁." and $text != "الغاء الامر ، 🎈" and $bc == "start" and $from_id == $admin){
file_put_contents("start.txt",$text);
SendMsg($admin,"تم حفظ رسالةه الاستارت ، 💌.","Markdown",True,$kb,$message_id); unlink("bc.txt");}

#