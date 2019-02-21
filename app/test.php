<?php

function Shortlink_Check($Second_redirect=array(),$Second_server='',$is_shortlink=true,$img='', $flag = 'null' , $flag2 = 0){


		Global $linkUniq,$grp_entity,$listId,$database_connection,$database_connection_mysqli,$entity,$MultiThreading,$GrpServ,$Pfx_serv;
        Global $message_safe, $is_multi_redirect, $BellafkiInstance2, $BellafkiInstance, $serverApi, $starttime, $session_prefix;

        echoIT('+$Second_redirect+');
        echoIT($Second_redirect);

        if(empty($starttime)){
                $starttime = microtime(true);
        }

        if($flag2 == 4 ){
         $is_shortlink = false;
        }

        if( (!in_array($_SESSION[$session_prefix."Id"], $BellafkiInstance)  and !in_array($_GET["cnfNum"], $BellafkiInstance)) and $is_shortlink and $flag2!=3 ){
                $flag2 = '2';
        }

        unset($Second_redirect['http://']);
        unset($Second_redirect['https://']);
		
        if($is_shortlink and $flag2!=2){
                $cpt = 0;

                foreach($Second_redirect as $rrr){
                        $coding_type = substr( $rrr, -6, 1);


                        #---> url like codage 0
                        $tmp3 = explode('?', $rrr);
                        $tmp4 = explode('.', $tmp3[1]);
                        $tmp00 = explode('=', $tmp4[0]);
                        $ofiddd = substr($tmp00[1], 1); 


                        if ( !preg_match('/o[0-9]{2}.*/', substr($ofiddd, 0, 3) ) AND !preg_match('/gpv.*/', substr($ofiddd, 0, 3) ) AND !preg_match('/lbm.*/', substr($ofiddd, 0, 3) ) AND !preg_match('/gpl.*/', substr($ofiddd, 0, 3) ) )
                        {
                                $ofiddd = substr($ofiddd, 5);             
                        }
                        #echoIT("offerid is $ofiddd");
                        Global $coding_types_Array;
                        if ( ( preg_match('/o[0-9]{2}.*/', substr($ofiddd, 0, 3) ) or preg_match('/gpv.*/', substr($ofiddd, 0, 3) ) or preg_match('/lbm.*/', substr($ofiddd, 0, 3) ) or preg_match('/gpl.*/', substr($ofiddd, 0, 3) ) /*or in_array($coding_type, $coding_types_Array)*/ ) and $flag2!=2 )
                        {
                                #nothing
                                $flag = '1';
                        }else{
                                $flag = 'null';
                        }


                        if ( $flag != 'null' )
                        {

                                if ( $_SESSION[$session_prefix."Id"] == 271 or $_SESSION[$session_prefix."Id"] == 731 ) { echo '$rrr ' . $rrr . '<br>'; echo '-api ' . $api . '<br>'; echo ' $coding_type ' . $coding_type . '<br>'; }


                                $tmp = explode('?', $rrr);

                                $tmp1 = explode('.', $tmp[1]);

                                if ( $_SESSION[$session_prefix."Id"] == 271 )             echo '<pre>'; print_r( $tmp1 ); echo '</pre>';

                                $tmp2 = explode('=', $tmp1[0]);

                                if ( $_SESSION[$session_prefix."Id"] == 271 )             echo '<pre>'; print_r( $tmp2 ); echo '</pre>';

                                $ofid = substr($tmp2[1], 1);            

                                if ( $_SESSION[$session_prefix."Id"] == 271 )           echo ' --$ofid ' . $ofid . '<br>'; 


                                if ( $_SESSION[$session_prefix."Id"] == 271 )             echo '<pre>'; print_r( $tmp ); echo '</pre>';

                                if ( !preg_match('/o[0-9]{2}.*/', substr($ofid, 0, 3) ) AND !preg_match('/gpv.*/', substr($ofid, 0, 3) ) AND !preg_match('/lbm.*/', substr($ofid, 0, 3) ) AND !preg_match('/gpl.*/', substr($ofid, 0, 3) ) )
                                {
                                                $ofid = substr($ofid, 5);             
                                }

                                if ( $_SESSION[$session_prefix."Id"] == 271 )  
                                {
                                   echo '<pre>'; print_r( $tmp ); echo '</pre>';
                                        echo ' $ofid ' . $ofid . '<br>';
                                }

                                if ( preg_match('/o[0-9]{2}.*/', substr($ofid, 0, 3) ) OR preg_match('/gpv.*/', substr($ofid, 0, 3) ) OR preg_match('/lbm.*/', substr($ofid, 0, 3) ) OR preg_match('/gpl.*/', substr($ofid, 0, 3) ) )
                                                {
                                        $cpt++;
                                }
                        }

                }
                 if ( $_SESSION[$session_prefix."team"] == 'IT' ){
                {
                        echo '  +Second_redirect+  ' . count($Second_redirect) . ' --- ' . $cpt . '<br>';
                        echo '<pre>'; print_r($Second_redirect); echo '</pre>';
                }

                if (  $flag != 'null' ){

                        if ( count($Second_redirect) == $cpt ) {
                        $GLOBALS [Second_redirectCpt] = $GLOBALS [Second_redirectCpt]+1;
                        $timeee = microtime(true)-$starttime;
                                echoIT("1. Shortlink_Check time: $timeee"); 
                        return $Second_redirect;

                        }
                }

        }

        if($flag2 == 2){
                Global $First_redirect;
        }

        #max server proxy
        $count_check = 3;

        if($GLOBALS [Second_redirectCpt]== $count_check  ){
                $linkUniq_0 = implode('<br/>',$linkUniq);
                        Global $First_redirect;
                        print_r($First_redirect);
                        $GLOBALS [Second_redirectCpt] = 0;
                        $timeee = microtime(true)-$starttime;
                        echoIT("$linkUniq_0 3. Shortlink_Check time: $timeee"); 
                        if ( $_SESSION[$session_prefix."team"] == 'IT' ){
                                echoIT("wrong links->");print_r($Second_redirect);
                        } 
                        $CnfNumVal = intval($_GET['cnfNum']);
                        $SesId = intval($_SESSION[$session_prefix."Id"]);
                        $msgidChange = $GLOBALS[messageid];
                        if(empty($msgidChange)){
                                $msgidChange = $CnfNumVal;
                        }
                        Global $id_s_news;


                        $id_s_newsTMpp = $id_s_news;
                        if(empty($id_s_newsTMpp)){
                                if($_POST["mode"]){
                                        $id_s_newsTMpp = 'test';
                                }
                                if(empty($id_s_newsTMpp)){
                                        Global $message;
                                        $id_s_newsTMpp = $message [id_s_news];
                                }
                        }
                        echoIT("id s new tmp -> $id_s_newsTMpp");
                        if($id_s_newsTMpp != 'test'){
                                $isNotok = false;
                                foreach($Second_redirect as $keyyy=>$Rsss){
									#2018-12-28
									$keyyy = str_replace('https://','',$keyyy);
									$keyyy = str_replace('http://','',$keyyy);
									$keyyy = str_replace('www.','',$keyyy);

									$msgNote = "NP 0.1.33 Alert!! sorry but Verify and Check Your url's $keyyy " ;
									show_notification( $msgNote, $type='error');
									$isNotok = true;
									$Querryyy = $database_connection_mysqli->query(" insert into Global_Stats.wrong_links values('','$msgidChange','$listId','$CnfNumVal','$keyyy','$Rsss','$SesId',now())");
									echoIT(" insert into Global_Stats.wrong_links values('','$msgidChange','$listId','$CnfNumVal','$keyyy','$Rsss','$SesId',now())");
                                }
                                if($isNotok == true){
                                        exit();
                                }
                        }



                        return $First_redirect;
        }


        if($Second_server == 'Second_server'){
			$SQL = " select  serverId from shared_db_domips.servers where active    order by rand() limit 1; ";
			$query = $database_connection_mysqli->query($SQL);
			if(!$query){
					 die ("SQLSTATE 53");
			 }
			 while (  $row = $query->fetch_object()) {
					$serverApi = $row->serverId;
			 }
			echoIT($SQL);
        }else
		{
		 $serverApi = $Pfx_serv;
        }
        $shortsrv = parse_url( $linkUniq[0] );
        $isShortlink = 1;
        $logss_shortlink = array();
        $shr_uniqid = uniqid();
        $iD_shortlink = array();
        $id_sh = 0;


        $linkUniqTmp = $linkUniq;

        if(!empty($Second_redirect)  )$linkUniqTmp = $Second_redirect;

        if ( $_SESSION[$session_prefix."team"] == 'IT' ){
                echo 'aaaAAA<pre>'; print_r( $linkUniqTmp ); echo '</pre>';
        }


        foreach( $linkUniqTmp as $url_sht )
        {
                $old_urll = $url_sht;
                echoIT("urlllll $old_urll");
                if(empty($old_urll))continue;


                $iD_shortlink[$id_sh] = $url_sht;

                if(stristr($url_sht,'mailto:'))continue;

                $url_sht = urlencode($url_sht);
                $timeout = 60;

                echoIT("server api $url_sht #odl $old_urll# -> $serverApi");
                $url_sh = urldecode($url_sht); 


                $curl_RemoveParam = array();
 
                if(stristr($old_urll,'dwz.team') or stristr($old_urll,'fastlink.bid') ){
                        $url_sht = 'https://'.$url_sht;
                }
                if(empty($curl_RemoveParam)){
                        $apar = array('url'=>$url_sh, 'url2'=>'', 'timeout'=>$timeout, 'img'=>$img, 'flag2'=>$flag2,'Version'=>'V3.0','HTTP_CODE'=>'searchguide.level3.com/search/','CptLimit'=>$GLOBALS [Second_redirectCpt]);
                }else{
                        $apar = array('url'=>$url_sh, 'url2'=>'', 'timeout'=>$timeout, 'img'=>$img, 'flag2'=>$flag2,'curl_RemoveParam'=>$curl_RemoveParam,'Version'=>'V3.0','HTTP_CODE'=>'searchguide.level3.com/search/','CptLimit'=>$GLOBALS [Second_redirectCpt]);
                        #print_r($apar);exit();
                }
                $par = serialize($apar);
                $par = base64_encode($par);
                $par = urlencode($par); //added by Souri 20180104
                #change server api
                if($serverApi =='ssm3940' or $serverApi =='gss962' or $serverApi =='tace03' or $serverApi =='tace02')
                {
                        $serverApi = 'ssm3181';
                }
                $apiChecker = "http://pqWebService." . $serverApi . "/RedirectCheck.php?par=".$par;

                /* by ettoini */ //$apiChecker = "http://pqWebService." . $serverApi . "/RedirectCheck.php?url=$url_sht&url2=&timeout=$timeout&img=$img&flag2=$flag2";
                echoIT($apiChecker);


                $logId = ($is_shortlink)?'/tmp/logGrpS/RedirectCheck/'.$shr_uniqid.'_'.$id_sh:'/tmp/logGrpS/RedirectCheck/urlclick'.$shr_uniqid.'_'.$id_sh;
                exec(" wget -qO- ". escapeshellarg($apiChecker) ." > ".escapeshellarg($logId)." & ");
                $logss_shortlink[$logId] = $logId;

                $id_sh ++;
        }

        $timeout2 = 20;

        echoIT ('+logss_shortlink+');
        echoIT( $logss_shortlink ); 
        $log_shortlink_error = AsyncProcessLink($logss_shortlink,'End',array('-1'),$timeout2);

        $Shortlink_errors = array();
        $Exit = false;

        if( (!$is_shortlink and ( $GLOBALS[entity] == 'opm03' OR $_SESSION[$session_prefix."Id"] == 1133 ) and /*$GLOBALS[endLoop] !=1 */ stristr($message_safe,'[extradom]') ) /*or 1==1*/ ){
                $array_new_extradomss_err = array();
                foreach($log_shortlink_error[timeout] as $keytimeout=>$value_timeout){
                        $arra_tm = explode('_',$keytimeout);
                        $domain_out = $arra_tm[count($arra_tm)-1];
                        $domain_out = str_replace('.log','',$domain_out);
                        $shortlink_url = $iD_shortlink[$domain_out];
                        $arrayTmpp = array();
                        $arrayTmpp = parse_url( $shortlink_url );
                        $domain_out = $arrayTmpp[host];
                        $msgNote = " $domain_out Error ";
                        show_notification( $msgNote, $type='info');
                        $array_new_extradomss_err[$domain_out] = $domain_out;
                }
                foreach($log_shortlink_error[errors] as $keytimeout=>$value_timeout){
                        $arra_tm = explode('_',$keytimeout);
                        $domain_out = $arra_tm[count($arra_tm)-1];
                        $domain_out = str_replace('.log','',$domain_out);
                        $shortlink_url = $iD_shortlink[$domain_out];
                        $arrayTmpp = array();
                        $arrayTmpp = parse_url( $shortlink_url );
                        $domain_out = $arrayTmpp[host];
                        $msgNote = " $domain_out Error ";
                        show_notification( $msgNote, $type='info');
                        $array_new_extradomss_err[$domain_out] = $domain_out;
                }
                $array_new_extradomss = array();
                //max 50 extradom valable
                $counttt = 50;$cpttt = 0;
                foreach( $log_shortlink_error[success] as $domserv2=>$act )
                {
                        $arra_tm = explode('_',$domserv2);
                        $domain_out = $arra_tm[count($arra_tm)-1];
                        $domain_out = str_replace('.log','',$domain_out);
                        $shortlink_url = $iD_shortlink[$domain_out];
                        $parse_new_do = parse_url($shortlink_url); 
                        if(isset($array_new_extradomss_err[$parse_new_do['host']]))continue;
                        $array_new_extradomss[$parse_new_do['host']] = $parse_new_do['host'];
                        $cpttt++;
                        if($counttt==$cpttt and $_SESSION[$session_prefix."Id"] != 1133 )break;
                }

                if(empty($array_new_extradomss)){
                        show_notification( "Extra ,doms is empty", $type='error');
                        die(""); 
                }
                $array_new_extradomss2 = implode(chr(10),$array_new_extradomss);
                $msgidChange = $GLOBALS[messageid];
                $queryy = " update message set extradom = '$array_new_extradomss2' where id = $msgidChange ; ";
                $result=$database_connection_mysqli->query($queryy);

                if(!$result){
                        die("SQLSTATE 56");
                }

        }else{
      if( count($log_shortlink_error[timeout]) != 0 ){
        $Exit = true;
        foreach($log_shortlink_error[timeout] as $rsSh=>$EndValye){
                list($file_sh_name,$shortlink_url) = explode('_',$rsSh);
                $Shortlink_errors[$iD_shortlink[$shortlink_url]] = $iD_shortlink[$shortlink_url];
                $msgNote = $msgNote.'Failed to resolve the shortlink: [' . $iD_shortlink[$shortlink_url] . '] <br/> ';
        }
      }
      if(   count($log_shortlink_error[errors]) != 0 ){
        $Exit = true;
        foreach($log_shortlink_error[errors] as $rsSh=>$EndValye){
                list($file_sh_name,$shortlink_url) = explode('_',$rsSh);
                $Shortlink_errors[$iD_shortlink[$shortlink_url]] = $iD_shortlink[$shortlink_url];
                $msgNote = $msgNote.'Failed to resolve the shortlink: [' . $iD_shortlink[$shortlink_url] . '] <br/>';
        }
      }
        }

        $Second_redirect = array();
        foreach($log_shortlink_error[success] as $rsSh=>$EndValue){

                list($file_sh_name,$shortlink_url) = explode('_',$rsSh);

                $shortlink_url = $iD_shortlink[$shortlink_url];
                unset($header);
                $header = ` cat $rsSh `;

                echoIT(' +shortlink_url+ ' . $shortlink_url);

                $original_url = Shortlink_extract($header,$shortlink_url,$is_shortlink);
                $original_url = original_url_replace($original_url);


                #Shortlink Second Redirect

                if (   $is_shortlink == 'yes' and ( preg_match('/.*appbilities.com.*/', $original_url)) or  ( preg_match('/.*hiden.one.*/', $original_url))  or (preg_match('/.*activehosted.com.*/',$original_url)) or (preg_match('/.*url.bjy.be*/',$original_url))   or (preg_match('/.*mrh.cmail19.com.*/',$original_url))   or  preg_match('/.*activehosted.com--.*/', $original_url) OR preg_match('/.*ow.ly.*/', $original_url)   or ( preg_match('/.*url.snd.*ch.*/', $original_url) or stristr($original_url,'wix.com/so/bLVcpwKJ/click')  or stristr($original_url,'wix.com/so/0LBCTZwM/click')  or stristr($original_url,'-t.co/')  or stristr($original_url,'-groups.yahoo.com/neo/groups/-') or stristr($original_url,'---linkbucks.com')  or stristr($original_url,'bit.ly--') or stristr($original_url,'laforksbu.com/1A0me21hpkwwwwx00000001025vu900vy1') or stristr($original_url,'laforksbu.com/1A0me21hplwwwwx00000001025vu900vy1')   or stristr($original_url,'urinalitelk.com/---')    ))
                {
                        #die("yes");
                        $Second_redirect[$original_url] = $original_url;
                        continue;
                }elseif(!$is_shortlink and $flag2 != 4){
                        $arrayTmpp = array();
                        $arrayTmpp = parse_url( $original_url );
                        $domserv1 = $arrayTmpp[host];
                        $arrayTmpp = array();
                        $arrayTmpp = parse_url( $shortlink_url );
                        $domserv = $arrayTmpp[host];
                        $ot = array(); $tmp = '';
                        if (  ( ($domserv1 == $domserv OR preg_match('/.*cefsk.ca/', $domserv) OR preg_match('/.*ingarden.pt/', $domserv) OR preg_match('/.*dynu.com/', $domserv) OR preg_match('/.*wroth.org/', $domserv) OR preg_match('/.*flexible-demeanor.com/', $domserv)  OR preg_match('/.*cybernetx.org/', $domserv)  OR preg_match('/.*diafilme.ro/', $domserv)  OR  preg_match('/.*melbvans.com.br/', $domserv)  OR preg_match('/.*fttthyhyh.wix.com/', $domserv) ) and !preg_match("/index.html/", $original_url) and !preg_match("/email=/", $original_url)) )
                        {

                                $Second_redirect[$original_url] = $original_url;
                                continue;
                        }
                }
                elseif(stristr($shortlink_url,'taut.in')){
					
                    $First_redirect [$shortlink_url] = substr($original_url, 0, -1);
                }
                else{
                    $First_redirect [$shortlink_url] = $original_url;

                }
        }

        if($flag2==2){
                #return $First_redirect;
        }
        if(!empty($Second_redirect)){
                $GLOBALS [Second_redirectCpt] = $GLOBALS [Second_redirectCpt]+1;

                echoIT(" Shortlink_Check 5");
                $First_redirect_0 = Shortlink_Check($Second_redirect,'',$is_shortlink,$img,$flag,$flag2);
                $First_redirect = array_merge($First_redirect,$First_redirect_0);

                echoIT("merge First_redirect First_redirect_0");
        }
        if($Exit){

                $GLOBALS [Second_redirectCpt] = $GLOBALS [Second_redirectCpt]+1;
                echoIT(" Shortlink_Check 6");
                $First_redirect_1 = Shortlink_Check($Shortlink_errors,'Second_server',$is_shortlink,$img,$flag,$flag2);

                $First_redirect = array_merge($First_redirect,$First_redirect_1);
                echoIT("merge First_redirect First_redirect_1");
        }
        $GLOBALS [Second_redirectCpt] = 0;
        #if($img!=''){$First_redirect = array();$First_redirect_1 = array();}
        $timeee = microtime(true)-$starttime;
        echoIT("End  Shortlink_Check time: $timeee <br/>".implode('<br/>',$First_redirect));


        return $First_redirect;
}
}
