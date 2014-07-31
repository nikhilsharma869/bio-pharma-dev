
<!-- include "common functions" library -->
<script type="text/javascript" src="../../js/common_functions.js"></script>

<!-- include "prototype" library -->
<script type="text/javascript" language="JavaScript" src="../../util/prototype/prototype.js"></script>
<table width="95%" align="center">
	
	<td>
		<script language="JavaScript">

function isEntries_Valid(isProject)
{
	var isOk = true;
	var aMessage = "";
	if (isProject)
	{
		isOk = ($('id').value != "");
		if (!isOk)
		{
			aMessage = "Invalid project selection.\n";

		}

		isOk = isOk && ($('comments').value.length >= 200);
		if ($('comments').value.length < 200)
		{
			aMessage += "Please provide an explanation with minimum of 200 characters.\n";			
		}


	

		isOk = isOk && ($('selected_percentage').value != -1);
		if ($('selected_percentage').value == -1)
		{

				aMessage += "Please select a percentage proposal.\n";
		}
		if (!isOk)
		{
			alert(aMessage);
		}
		return isOk;

	}
	else
	{
		isOk = ($('question_case_project_id').value != "");
		if (!isOk)
		{
			aMessage = "Invalid project selection.\n";

		}

		isOk = isOk && ($('question_comments').value.length >= 200);
		if ($('question_comments').value.length < 200)
		{
			aMessage += "Please provide an explanation with minimum of 200 characters.\n";			
		}


		isOk = isOk && ($('questionselected_reason').value != -1);
		if ($('questionselected_reason').value == -1)
		{

				aMessage += "Please select a reason.\n";
			}
			

		isOk = isOk && ($('question_selected_percentage').value != -1);
		if ($('question_selected_percentage').value == -1)
		{

				aMessage += "Please select a percentage proposal.\n";
		}
		if (!isOk)
		{
			alert(aMessage);
		}
		return isOk;
	
	}


return isOk;
}
			


		function removeOption(id)
		{
			var obj = document.getElementById('select_files');
		   	if(obj != null)
		  	{
		  		for(i=0; i< obj.options.length;i++)
		  		{
		  			if(obj.options[i].value == id)
		  			{
		  				obj.options[i] = null;
		  				break;
		  			}
		  		}
		  	}
		}
		
		
		
		function addOption(value,title)
		{
			var obj = document.getElementById('select_files');
		   	if(obj != null)
		  	{
		  		obj.options[obj.options.length] = new Option (title,value);
		  	}
		}
	
		function CalculatePercentage(aSelf)
		{
			var projectcost = 120;
			var usertype = document.getElementById('users_type').value;
			var percentCalculated = document.getElementById('shallBeReleasedSumm');
			var percentCalculated2 = document.getElementById('shallReturnToMe');
			var percentCalculated3 = document.getElementById('userTypeSelected');
			var percentage = aSelf.value;
			var aCalculatedRemain = 100 - percentage;
			var aCalculatedValue = 0;
			var aCalculatedValue2 = 0;


			if(percentage > 0 ) {
				aCalculatedValue = ( percentage / 100 )* projectcost;
			} else {
				aCalculatedValue = 0;
			}
			
			
			if( (aCalculatedRemain > 0 ) && (percentage != -1 ) ){
				aCalculatedValue2 = ( aCalculatedRemain / 100) * projectcost;
			} else {
				aCalculatedValue2 = 0;
			}
	
			if(usertype == 'buyer') {
				percentCalculated.innerHTML = aCalculatedValue2.toFixed(2);
				percentCalculated2.innerHTML = aCalculatedValue.toFixed(2);

			} else {
				percentCalculated.innerHTML = aCalculatedValue2.toFixed(2);
				percentCalculated2.innerHTML = aCalculatedValue.toFixed(2);
			}
		
			document.getElementById('selected_percentage').value = percentage;
			if(percentage == -1) {
				document.getElementById('selected_percentage').value = 0;
			}
		}

		function init_def()
		{
			var percentage = document.getElementById('percentage');
			var usertype = document.getElementById('users_type');

			if( percentage == null ){
				percentage = -1;
			} 
			var selected_percentage = document.getElementById('selected_percentage');
			
			if( selected_percentage == null ){
				selected_percentage = -1;
			} 
			

	
			
		}
		
		init_def();

		var obj = document.getElementById('select_files');
		
		if( obj != null )
		{
			var opt = obj.options;
			
			for( var i = 0; i < obj.options.length; i++ )
			{
				obj.options[i].selected = true;
			}			
		}
		 
	



		
		//alert(selected_percentage);
		//if(selected_percentage != -1) {
		 //document.getElementById('percentage').value = percentage;
		 //CalculatePercentage(selected_percentage);
		//}
		
		</script>
		<center>
			<table width="100%" border=0 cellpadding=0 cellspacing=0>


		  <tr>

		      <td>


		     <br />
		<br />
		      <center>
			      <table border="0" width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber1">
				      				<tr>
					<td colspan=2>			<div align=left>
							<span style="font-weight: 700; font-size: 14px">Resolution Center</span><br/>&nbsp;
				
			</div>
</td>
				</tr>

		        <tr>
				  <td width="1" bgcolor="#C0C0C0">&nbsp;</td>
		          <td bgcolor="#C0C0C0" width="180" valign="top"><font face="Verdana" size="2">Case</font><font face="Verdana" style="font-size: 10pt"> ID</font></td>
		          <td bgcolor="#EFEFEF"><font face="Verdana" size="2">&nbsp; </font> </td>
		          <td bgcolor="#EFEFEF"><font face="Verdana" style="font-size: 10pt">DFC532C60986CDEF</font></td>
		        </tr>
		        <tr>
				  <td width="1" bgcolor="#C0C0C0">&nbsp;</td>
		          <td bgcolor="#C0C0C0" width="180" valign="top"><font face="Verdana" size="2">Case Name</font></td>
		          <td bgcolor="#EFEFEF">&nbsp;</td>
		          <td bgcolor="#EFEFEF"><font face="Verdana"> <big style="font-size: 10pt; font-weight: bold"> <a href="../../projects/ebay_template_design_124875.html" target="_blank" style="font-weight: normal; text-decoration: underline"> <b style="font-weight: bold">Ebay Template Design</b></a></big><font size="2"> </font></font> </td>
		        </tr>
		        <tr>
				  <td width="1" bgcolor="#C0C0C0">&nbsp;</td>
		          <td bgcolor="#C0C0C0" width="180" valign="top"><font face="Verdana" style="font-size: 10pt">Job Type</font></td>
		          <td bgcolor="#EFEFEF">&nbsp;</td>
		          <td bgcolor="#EFEFEF"><font face="Verdana" style="font-size: 10pt">Project</font></td>
		        </tr>
		        <tr>
				  <td  width="1" bgcolor="#C0C0C0">&nbsp;</td>
		          <td bgcolor="#C0C0C0" width="180" valign="top"><font face="Verdana" style="font-size: 10pt">Amount in dispute&nbsp; </font></td>
		          <td bgcolor="#EFEFEF">&nbsp;</td>
		          <td bgcolor="#EFEFEF"><font face="Verdana" style="font-size: 10pt">$120.00 USD in Milestone 
		            Escrow</font></td>
		        </tr>
		        <tr>
				  <td width="1" bgcolor="#C0C0C0">&nbsp;</td>
		          <td bgcolor="#C0C0C0" width="180" valign="top"><font face="Verdana" size="2">Status</font><font face="Verdana" style="font-size: 10pt">&nbsp; </font></td>
		          <td bgcolor="#EFEFEF">&nbsp;</td>
			  <td bgcolor="#EFEFEF">
<font face="Verdana" size="2"><b>13 days left</b> to come into an 
		            agreement. If until that time both sides don't come into an agreement 
		            our dispute department will review the uploaded evidences and take a 
			    decision on how to settle this dispute.
	    </font> 
</td>
		        </tr>
		      </table>
		      <p>      
		      <table border="0" width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber2">
		        <tr>
				  <td height="19" width="1" bgcolor="#C0C0C0">&nbsp;</td>
		          <td bgcolor="#C0C0C0" width="180">Buyer Says&nbsp;&nbsp; </td>
		          <td height="19" width="1" bgcolor="#EFEFEF">&nbsp;</td>
			  <td height="19" bgcolor="#EFEFEF"><font face="Verdana" size="2">I received <b>0%</b> of the work related to the <b>$120.00</b> Milestone Escrow. <b>scriptgiant</b> should receive <b>$0.00</b> and <b>$120.00</b> should return to me.</font></td>
		        </tr>
		      </table>
		      <br />
		    
		      <table border="0" width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber2">
		        <tr>
				 <td height="19" width="1" bgcolor="#C0C0C0">&nbsp;</td>
		          <td height="19" bgcolor="#C0C0C0" width="180">Provider Says&nbsp;&nbsp;</td>
		          <td height="19" width="1" bgcolor="#EFEFEF">&nbsp;</td>
		          <td height="19" bgcolor="#EFEFEF"><font face="Verdana" size="2">Not Yet Proposed</font></td>
		        </tr>
		      </table>
			  <br />
		      <form action="../../users/onresolve.php" method="post" enctype="multipart/form-data" style="font-size: 13px; color: #000000; font-weight: normal" onsubmit='return isEntries_Valid(1);'>
		        <input type="hidden" name="back" value="L3VzZXJzL3Jlc29sdmUucGhwP2lkPTEyNDg3NQ==">
				<input type="hidden" id="id" name="id" value="124875">
				<input type="hidden" value="162912" id="users_id" name="users_id" style="font-size: 13px; color: #000000; font-weight: normal" />
				
				<input type="hidden" value="DFC532C60986CDEF" id="case_id" name="case_id" style="font-size: 13px; color: #000000; font-weight: normal">
				<input type="hidden" value="buyer" name="users_type" id="users_type" style="font-size: 13px; color: #000000; font-weight: normal" />
		        <input type="hidden" value="162912" name="counterparty_id" id="counterparty_id" style="font-size: 13px; color: #000000; font-weight: normal" />
				<input type="hidden" value="scriptgiant" name="counterparty_username" id="counterparty_username" style="font-size: 13px; color: #000000; font-weight: normal" />			  
				
				<input type="hidden" value="120" name="case_amount" style="font-size: 13px; color: #000000; font-weight: normal" />
				<center>
			   
				 <table style="width: 100%; border-collapse: collapse; border: 0px solid #666666" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" bordercolor="#111111">
					<tr><td>	<span style="font-weight: 700"><font face="Verdana">Your Message</font></span><font face="Verdana">:<br />
				          </font>
				            <textarea style="width: 100%; font-size: 13px; color: #000000; font-weight: normal" id="comments" name="descr" rows="6" cols="62"></textarea>
							<br/><br/>
					</td></tr>
				</table>
		            <table style="width: 100%; border-collapse: collapse;  border: 0px solid #666666" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" bordercolor="#111111"  id="FileUploadProjectInfo">
		              <tr>
		                <td width="220" style="font-size: 13px; color: #000000; font-weight: normal"><font face="Verdana" style="font-size: 8pt">Upload any evidence you may 
		                  consider 
		                  important:</font> </td>
		                <td width="400" style="font-size: 13px; color: #000000; font-weight: normal">
				          	<SELECT id="select_files" style="WIDTH: 100%; HEIGHT: 55px" multiple size=2 name="files[]">
				          		
				          	</SELECT>
						</td>
				          <TD width="20">&nbsp; </TD>
				          <TD width="100">
				            <TABLE cellSpacing=0 cellPadding=0 border=0>
				              <TBODY>
				              <TR>
				                <TD><INPUT style="WIDTH: 80px" onclick="window.open('../sellers/dispute_upload.php','','width=400, height=200, left=100,top=100,menu=no,toolbar=no,scrollbars=no');" type=button value="Add File"> 
				                </TD></TR>
				              <TR>
				                <TD><INPUT style="WIDTH: 80px" onclick="removeFiles();" type="button" value="Remove"> 
				                </TD>
				              </TR>
				             </TBODY>
								<script language="JavaScript">
								    function removeFiles()
										{
											var idArr  = Array();
											var url ="/sellers/dispute_delete_up.php?idArr=";
											
											var obj = document.getElementById('select_files');
											if(obj != null)
											{
												for(i=0;i< obj.options.length;i++ )
												{
													if(obj.options[i].selected)
													{
														idArr[idArr.length] = obj.options[i].value;
													}		
												}
											}
											if(idArr.length <=0)
											{
												alert('Not Selected Items!');
											}
											else
											{
												var str ='';
												for(i=0; i< idArr.length; i++ )
												{
													str = str + idArr[i]+',';
												}
												//alert(str);
												window.open(url+str,'','width=300, height=200,menu=no, toolbar=no,scrollbars=yes,location=no, directories=no, status=no, left=1,top=1,resizable=yes');
												
											}
											//alert(idArr);
											
										}
									</script>
			
				            </TABLE>
				          </TD>
		              </tr>
		            </table>


		              <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse" bordercolor="#111111">
		                <tr>
		                  <td><br />
		                      <!-- ######################################################### -->
		                      <table style="width: 100%; border-collapse: collapse; border: 0px solid #666666" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" bordercolor="#111111">
		                        <tr>
		                          <td style="padding: 5px"><span style="font-weight: 700"> <font face="Verdana" size="2" color="#333333">Your Proposal</font></span><font face="Verdana" size="2"><span style="font-weight: bold; color: #333333">:</span><font color="#333333"> </font></font></td>
		                          <td style="PADDING-RIGHT: 5px; PADDING-LEFT: 5px; PADDING-BOTTOM: 5px; PADDING-TOP: 5px; TEXT-ALIGN: left"><font face="Verdana">
		                            <select id="percentage" onchange="CalculatePercentage(this);" size="1" name="percentage"> 
									  <option value="-1">None</option>
									  <option value="100">100%</option>
		                              <option value="75">75%</option>
		                              <option value="50">50%</option>
		                              <option value="25">25%</option>
		                              <option value="0">0%</option>
		                            </select>
		                            <font size="2"> of the work was received</font></font>
									<input type="hidden" value="-1" id="selected_percentage" name="selected_percentage" style="font-size: 13px; color: #000000; font-weight: normal">
								</td>
		                          <td style="padding: 5px">&nbsp;</td>
					  <td style="padding: 5px" width="300" rowspan="2" valign="top"></td>
		                        </tr>
		                        <tr>
		                          <td style="padding: 5px" valign="top"><font color="#333333" face="Verdana" size="2">&nbsp;</font></td>
		                          <td style="PADDING-RIGHT: 5px; PADDING-LEFT: 5px; PADDING-BOTTOM: 5px; PADDING-TOP: 5px; TEXT-ALIGN: left">
								  <table id="AutoNumber16" width="290" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-COLLAPSE: collapse; BORDER-RIGHT-WIDTH: 0px" bordercolor="#808080" cellspacing="0" cellpadding="4" bgcolor="#ffffff" border="0">
		                              <tr>
		                                <td style="BORDER-RIGHT: medium none; BORDER-TOP: medium none; BORDER-LEFT: medium none; BORDER-BOTTOM: medium none" align="right" height="10"><font face="Verdana" size="2"><b><font color="#009900">$<span id="shallBeReleasedSumm">0.00</span></font></b> </font></td>
		                                <td style="BORDER-RIGHT: medium none; BORDER-TOP: medium none; BORDER-LEFT: medium none; BORDER-BOTTOM: medium none" height="10"><font face="Verdana"><span style="font-size: 10pt">shall be released to sgd</span></font></td>
		                              </tr>
		                              <tr>
		                                <td style="BORDER-RIGHT: medium none; BORDER-TOP: medium none; BORDER-LEFT: medium none; BORDER-BOTTOM: medium none" align="right" height="10"><font face="Verdana" size="2"><b><font color="#cc0000">$<span id="shallReturnToMe">0.00</span></font></b> </font></td>
		                                <td style="BORDER-RIGHT: medium none; BORDER-TOP: medium none; BORDER-LEFT: medium none; BORDER-BOTTOM: medium none" height="10"><font face="Verdana"><span style="font-size: 10pt">will be sent to my account</span></font></td>
		                              </tr>
		                          </table></td>
		                          <td style="padding: 5px" valign="top">&nbsp;</td>
		                        </tr>
		                    </table></td>
		                </tr>
		              </table>
		          
		       
		        <p></p>
		        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="80%" id="AutoNumber17">
		          <tr>
				  <td width="100%" align="right"><input type="submit" value="Submit Message &amp; Proposal" name="submit" /></td>
		          </tr>
		        </table>
				<br/><br/><br/>
		      </form>
		      <table class="bordertable" cellspacing="0" cellpadding="3" width="100%" border="0">
		        <tr>
		          <th style="font-size: 13px; color: #FFFFFF; font-weight: bold; text-align: left; background-color: #6699CC"> User</th>
		          <th style="font-size: 13px; color: #FFFFFF; font-weight: bold; text-align: left; background-color: #6699CC"> Message</th>
		        </tr>
				 
		        <tr >
				
				<td valign="top" width="160" style="font-size: 13px; color: #000000; font-weight: normal"></strong>serap dalkilic</strong> ( <a href="../../users/sgd/" target="_blank" style="font-weight: normal; text-decoration: underline">sgd</a> )  <br />
		              <small style="font-size: 12">05-29-2010&nbsp;22:50</small></td>
		          <td valign="top" style="font-size: 13px; color: #000000; font-weight: normal">
				  <p align="left">I AM DISSAPOINTED WITH THE SERVICE WITH  scriptgiant  SO. COMMUNICATION IS POOR, HE IS NOT TAKING THE JOB SERIOUSLY. I LOST A WEEK AND DON`T HAVE ANY PROGRESS. I WANT TO END THIS AND AWARD THE JOB SOMEONE ELSE.rnrnSGD </p><BR>

				  

				  <div align="right"> &nbsp;</div></td>
		        </tr>
				
				
			   
		     
		      </table>
			  </center>
		       </td>
		  </tr>
		  <tr>
		    <td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td>&nbsp;</td>
		  </tr>
		     </table>

	
	</td>
</tr>
</table>
