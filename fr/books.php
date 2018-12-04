<center>
<?php	
	//include("pz_mysqlconn.php");
	$sql="select * from books where la_country='$lg' order by bo_index";
	$cs=connection("connect", "leela");
	$result=mysql_query($sql, $cs);
	while($rows=mysql_fetch_array($result))
	{
		$title=$rows["bo_title"];
		$author=$rows["bo_author"];
		$publisher=$rows["bo_publisher"];
		$description=$rows["bo_description"];
		$coverpath=$rows["bo_coverpath"];
		$isbn=$rows["bo_isbn"];
		?>
		<table cellspacing=0 cellpadding=0 border=2 bordercolor=#0 width='550'>
			<tr bgcolor=#0>
				<td align=left valign=top width='606'>
					<font size=2 color="white" face='ARIAL, HELVETICA'>
					<?php echo "$title - Auteur : $author - Editeur : $publisher - ISBN : $isbn"; ?>
					</font>
				</td>
			</tr>
			<tr bgcolor="lightgrey">
				<td>
					<table cellspacing=0 cellpadding=0>
						<tr>
							<td align=left width='460' valign=top>
								<font size=2 color="black" face='ARIAL, HELVETICA'>
								<?php echo "$description<br><br>"; ?>
								</font>
							</td>
							<td align=right width=146 valign=top>
								<?php echo "<img border=2 src='img/books/$coverpath.png' NOSAVE>"; ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br>
		<?php
	}
	mysql_free_result($result);
?>
</center>
