<?PHP  header("Content-Type: text/html; charset=utf-8");?>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
 
<?
 
function complete_mail() { 
         
$data=date("d.m.Y");
$time=date("h:i");
$res=" $data | $time ";
$ress=$_POST['name'];
$resss=" $res $ress ";
         
          
$_POST['title'] =  substr(htmlspecialchars(trim($_POST['title'])), 0, 1000); 
$_POST['mess'] =  substr(htmlspecialchars(trim($_POST['mess'])), 0, 1000000); 
$_POST['name'] =  substr(htmlspecialchars(trim($_POST['name'])), 0, 30); 
$_POST['tel'] =  substr(htmlspecialchars(trim($_POST['tel'])), 0, 30); 
$_POST['email'] =  substr(htmlspecialchars(trim($_POST['email'])), 0, 50);
         
$_POST['color'] =  substr(htmlspecialchars(trim($_POST['color'])), 0, 1000);
$_POST['itemtype'] =  substr(htmlspecialchars(trim($_POST['itemtype'])), 0, 1000);
$_POST['type_of_cover'] =  substr(htmlspecialchars(trim($_POST['type_of_cover'])), 0, 1000);
$_POST['page_url'] =  substr(htmlspecialchars(trim($_POST['page_url'])), 0, 1000);
$_POST['amount'] =  substr(htmlspecialchars(trim($_POST['amount'])), 0, 1000);
$_POST['date'] =  substr(htmlspecialchars(trim($_POST['date'])), 0, 1000);
$_POST['info'] =  substr(htmlspecialchars(trim($_POST['info'])), 0, 1000);
                  
// Проверка на валидность поля "Имя" - ошибка 0 
if (empty($_POST['name'])) 
output_err(0); 
// Проверка на валидность e-mail - ошибка 1 
if(!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $_POST['email'])) 
output_err(1); 
// тело письма.
$mess = '
         
<b>Цвет:</b>'.$_POST['color'].'<br />
<b>Комплектация:</b>'.$_POST['itemtype'].'<br />
<b>Тип чехла:</b>'.$_POST['type_of_cover'].'<br />
<b>Количество:</b>'.$_POST['amount'].'<br />
<b>Желаемая дата доставки:</b>'.$_POST['date'].'<br />
<b>Дополнительная информация о заказе:</b>'.$_POST['info'].'<br />
<b>Имя отправителя:</b>'.$_POST['name'].'<br /> 
<b>Телефон:</b>'.$_POST['tel'].'<br /> 
<b>email:</b>'.$_POST['email'].'<br />
<b>Телефон:</b>'.$_POST['page_url'].'<br />
<b>От куда Вы узнали о нас?:</b>'.$_POST['title'].'<br />
    
'.$_POST['mess']; 
 
// подключаем phpmailer. 
require 'class.phpmailer.php'; 
 
$mail = new PHPMailer();
$mail->CharSet = "UTF-8"; 
$mail->From = $from; // адрес, от кого письмо
$mail->FromName = $signature; // подпись от кого 
$mail->AddAddress('alexsaf91@mail.ru', 'Имя'); // Указываем свой e-mail
$mail->IsHTML(true); // Возможность вставки в письмо html 
$mail->Subject = $resss;  // тема письма
 
         
// если был файл, то прикрепляем его к письму 
if(isset($_FILES['attachfile'])) { 
    if($_FILES['attachfile']['error'] == 0){ 
    $mail->AddAttachment($_FILES['attachfile']['tmp_name'], $_FILES['attachfile']['name']); 
    } 
} 
// Для изображений, прикрепляем картинку к телу письма. 
if(isset($_FILES['attachimage'])) { 
    if($_FILES['attachimage']['error'] == 0){ 
        if (!$mail->AddEmbeddedImage($_FILES['attachimage']['tmp_name'], 'my-attach', 'image.gif', 'base64', $_FILES['attachimage']['type'])) 
        die ($mail->ErrorInfo); 
$mess .= 'Для отправки картынки:<br /><img src="cid:my-attach" border=0><br />В этом примере мы не будем это использовать ;-) '; 
                 } 
        } 
$mail->Body = $mess; 
 
// отправка письма
if (!$mail->Send()) die ('Mailer Error: '.$mail->ErrorInfo); 
    echo 'Спасибо! Ваше письмо отправлено.<p><a href="http://clickmyweb.net/">Вернитесь на главную</a></p>'; 
} 
 
function output_err($num) 
{ 
    $err[0] = 'ОШИБКА! Не введено имя.'; 
    $err[1] = 'ОШИБКА! Неверно введен e-mail.'; 
    $err[2] = 'ОШИБКА! Не введено сообщение.'; 
    echo '<p>'.$err[$num].'</p>'; 
//    show_form(); 
    exit(); 
} 
 
if (!empty($_POST['submit'])) complete_mail(); 
else show_form(); 
?> 
<?php
header('Refresh: 5; URL=http://saflex.ru/php/');
echo 'Через 5 секунд вы будете перенаправлены на главную страницу';
exit;
?>