<!-- PUT THE TEXT HERE -->
<!-- BEGIN -->
	<TABLE width=610>
		<TR>
			<TD>
				<TABLE  align=center width=410 border=2 bordercolor=#0 cellpadding="0" cellspacing="0">
					<TR>
						<TD bgcolor=#000000 align="center" >
							<font face="ARIAL, HELVETICA, SANS-SERIF" COLOR=#86DEF6 SIZE=3>
							<B><? echo $bigbrother ?></B></font>
						</TD>
					</TR>
					<TR>
						<TD>
							<font face="ARIAL, HELVETICA, SANS-SERIF" COLOR=#86DEF6 SIZE=1>
							<FORM ACTION=guestbook.php METHOD=POST>
								<INPUT TYPE=hidden NAME=action VALUE=fill>
								<INPUT TYPE=hidden NAME=dday value=dday>
							<table bgcolor=#336699 border=0 bordercolor=#0 cellspacing=0 cellpadding=0 width=410>
								<tr>
									<td align=left ><font size=1><B> NOM : </B></font><INPUT TYPE=text NAME=nickname SIZE=26 MAXLENGTH=25></td>
									<td align=right ><font size=1><B> VILLE : </B></font><INPUT TYPE=text NAME=city SIZE=26 MAXLENGTH=25></td>
								</tr>
								<tr>
									<td align=left ><font size=1><B> E-MAIL : </B></font><INPUT TYPE=text NAME=email SIZE=26 MAXLENGTH=35></td>
									<td align=right ><font size=1><B> SITE WEB : </B></font><INPUT TYPE=text NAME=link  SIZE=26 MAXLENGTH=50 value='http://'></td>
								</tr>
							</table></font>
						</TD>
					</TR>
					<TR>
						<TD ALIGN=center BGCOLOR=#72BEDE>
								<font face="ARIAL, HELVETICA, SANS-SERIF" COLOR=#163A66 SIZE=1>							<B>MESSAGE  : </B><BR>
								<TEXTAREA NAME=msg ROWS=16 COLS=48></TEXTAREA>
								<BR><BR>
								<INPUT TYPE=submit VALUE=Envoyer>
								<INPUT TYPE=RESET VALUE=Reset>
								</font>			
							</FORM>
						</TD>
					</TR>
				</TABLE><BR>
				<HR COLOR=#0 WIDTH=100% ALIGN=CENTER>
<?php
	require "include/connection.php";
	mysql_select_db($dbname);
	//alimentation du livre
	if ($action=="fill"){
		$action = "         ";
		if ($msg > "         " )
		{
			$dday = date ("Ymd");
			$hhour = date ("His");
			if ($link == "http://") {
				$link= " ";
			}
			$query = "SELECT * FROM guestbook where nickname = \"$nickname\" and dday = \"$dday\" and msg = \"$msg\"";
			$result = mysql_query($query, $mysql);
			$number = mysql_num_rows($result);
			if ($number == 0){
				$sqlresult=mysql_db_query("insert into guestbook values(\"$nickname\",\"$city\",\"$email\",\"$msg\",\"$dday\",\"$link\",\"$hhour\")", $mysql);
			}
			$nickname =  "          " ;
			$city = "           ";
			$email = "          ";
			$msg = "          ";
			$link = "        ";
			$action = "         ";
		}
	}
	// affichage des message
	$query = "SELECT * FROM guestbook order by dday desc, hhour desc";
	$result = mysql_query($query, $mysql);
	$number = mysql_num_rows($result);
?>
				<center><font face="ARIAL, HELVETICA, SANS-SERIF" SIZE="3" COLOR="#000000">
				<B><? echo $number ?></B></font>&nbsp;
				<font face="ARIAL, HELVETICA, SANS-SERIF" SIZE="3" COLOR="#86DEF6">
				<B>messages</B></font></center>
<?
	$cpt=0;
	if ($touche!="previous" && $touche!="next") {$i = 0;}
	if ($touche=="previous"){
		$i=$sav;
		$i  -= 5;
	}
	if ($touche=="next"){
		$i=$sav;
		$i += 5;
	}
	$previous_msg="<A HREF=guestbook.php?touche=previous&sav=";
	$previous_msg.=$i;
	$previous_msg.="><font face=\"ARIAL, HELVETICA, SANS-SERIF\" SIZE=3 COLOR=#000000 ><B>Messages pr�c�dents</B></A>";
	$next_msg="<A HREF=guestbook.php?touche=next&sav=";
	$next_msg.="$i";
	$next_msg.="><font face=\"ARIAL, HELVETICA, SANS-SERIF\" SIZE=3 COLOR=#000000 ><B>Messages suivants</B></A>";
	while ( $cpt<5 && $i<$number)
	{
		if ($number == 0) {
			print "<CENTER><P>Aucun message!</CENTER>";
		} elseif ($number > 0) {
			$nickname = mysql_result($result, $i, "nickname");
			$city = mysql_result($result, $i, "city");
			$email = mysql_result($result, $i, "email");
			$msg = mysql_result($result, $i, "msg");
			$dday = mysql_result($result, $i, "dday");
			$link = mysql_result($result, $i, "link");
			$hhour = mysql_result($result, $i, "hhour");
			if ($link == "http://") {$link= " ";}
?>
				<CENTER><BR>
				<TABLE border=2 bordercolor=#0 cellspacing=0 cellpadding=0 width=90%>
					<TR>
						<TD align=center bgcolor=#000000 width="100%">
							<font face="ARIAL, HELVETICA, SANS-SERIF" COLOR=#86DEF6 size=2>
							Message du <? echo $dday ?> � <? echo $hhour ?> </font>
						</TD>
					</TR>
					<TR>
						<TD>
							<TABLE bgcolor=#0 cellspacing=0 cellpadding=0 width=100%>
								<TR bgcolor=#336699 >
									<TD width="50%">
										<font face="ARIAL, HELVETICA, SANS-SERIF" COLOR=#86DEF6 size=2>
										Nom : <? echo $nickname ?></font>
									</TD>
									<TD width="50%">
										<font face="ARIAL, HELVETICA, SANS-SERIF" COLOR=#86DEF6 size=2>
										Ville : <? echo $city ?></font>
									</TD>
								</TR>
								<TR bgcolor=#336699 >
									<TD width="50%">
										<font face="ARIAL, HELVETICA, SANS-SERIF" COLOR=#86DEF6 size=2>
										E-mail : <A HREF=mailto:<? echo $email ?> ><? echo $email ?></A></font>
									</TD>
									<TD width="50%">
										<font face="ARIAL, HELVETICA, SANS-SERIF" COLOR=#86DEF6 size=2>
										Site web : <A HREF=<? echo $link ?> target='_new'><? echo $link ?></A></font>
									</TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR>
						<TD bgcolor=#72BEDE colspan="2">
							<font color=#0 face="ARIAL, HELVETICA, SANS-SERIF" SIZE=2><? echo $msg ?></font>
						</TD>
					</TR>
				</TABLE>
				</CENTER>
<?
				$i++;
				$cpt++;
			}
		}
		if ($i > 5){
			$previous=$previous_msg;
		}else{
			$previous="   ";
		}
		if ($i < $number){
			$next=$next_msg;
		}else{
			$next="   ";
		}
?>
				<BR><BR><CENTER>
			 	<TABLE width=100%>
					<TR>
						<TD width="50%" align="left">
							<B><B><font face="ARIAL, HELVETICA, SANS-SERIF" SIZE=2><? echo $previous ?></font></B>
						</TD>
						<TD width="50%" align="right">
							<B><font face="ARIAL, HELVETICA, SANS-SERIF" SIZE=2><? echo $next ?></font></B>
						</TD>
					</TR>
				</TABLE>
				</CENTER>
			</TD>
		</TR>
	</TABLE>
<!-- END -->

