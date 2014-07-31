<div class="browse_contract_right_box">
<form method="POST" action="<?=$vpath?>postmessage.php" enctype="multipart/form-data" onsubmit="javascript:return validatepost(this);">
		<input type="hidden" name="id" value="<?=$_REQUEST['id']?>">

		
<div class="browse_contract_right">
      <div class="browse_right_text">
        <h1><?=$lang['ASK_A_QUESTION'] ?></h1>
      </div>
      <br />
	<div class="cost_timing">
        <div class="cost_form_box">
		 <h1><?=$lang['MSG1_PSTD_H']?></h1>
          <textarea id="message" name="message" cols="" rows=""></textarea>
        </div> 
  <div class="cost_form_box">
          <h1><?=$lang['ATTACH']?></h1>
         <input type="file" name="attachment" size="35" class="text_box"><br><span style="color:red;width:100%;float:left;padding-left: 7px;"><?=$lang['ZIP_RAR_H']?></span>
        </div>	


<input type="submit" name="submit" value="Submit" class="submit_bott" style="margin: 6px 7px;"> 

</div>
	</div>
</form>	
		</div>