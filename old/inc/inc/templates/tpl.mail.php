<html>
	<style>

		#footer{
			background: white;
			height:40px;
			border-top: 1px solid grey;
			padding:5px;
		}
		#footer a{
			
		}
	</style>
	<body style="background: #007595;color:grey;margin:0;padding:0;width:100%;">
		<table style="margin:0;padding:0;border: 1px solid grey;width:100%;">
			<tr style="height:20px;">
				<td></td><td></td>
			</tr>
			<tr style="height:40px;background: white;height:40px;border-top: 1px solid grey;">
				<td style="width:600px;font-size:20px;font-weight:bold;padding:10px;">
					<span style="font-size: 25px;color:#007595"><?php echo $this->mailHeader; ?></span>
				</td>
				<td style="width:100px;font-size:20px;font-weight:bold;padding:10px;color:grey">
					<?php echo date('d.m.Y');?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="width:700px;padding:5px;height:400px;background: lightgrey; color:black;vertical-align:top;">
					<?php echo $this->mailContent;?>
				</td>
				
			</tr>
			<tr style="height:40px;background: white;height:40px;border-top: 1px solid grey;">
				<td colspan="2" style="width:700px;padding:5px;">
					<span color="grey">
						Lagerverwaltung eMailSystem
						<br>
						Kontakt: Christopher Jurthe 
						<a color="#007595" href="mailto:christopher.jurthe@zuumeo.com">eMail</a> 
						<a color="#007595" href="skype:chrisj.87">Skype</a>
					</span>
				</td>
				
			</tr>
			<tr style="height:20px;">
				<td></td><td></td>
			</tr>
		</table>
	</body>
</html>