<?
if(!isset($_SESSION)){ session_start();}
require_once('../includes/IO.php');

if (isset($_POST['proposalID']) && $_POST['proposalID'])
{
	$propID = ($_POST['proposalID']=='new')?newProposal():$_POST['proposalID'];
}
else if (isset($_GET['act']) && isset($_GET['pid']) && $_GET['act']=='view')
{
	$propID = $_GET['pid'];
}
else if (!isset($_SESSION['loggedin']) || ($_SESSION['loggedin'] == false))
{	
	header( 'Location: ' . $rootDir . '/user/login.php' );
}
if (!isset($propID) || $propID == NULL)
{
	header( 'Location: ' . $rootDir);
}

$_SESSION['getProposal'] = true;
$propInfo = getProposalData($propID);
if ($propInfo == 0) header( 'Location: '.$rootDir );

global $groups;

$u1 = $propInfo['username1']['username'];
$u2 = $propInfo['username2']['username'];
$u3 = $propInfo['username3']['username'];
$u4 = $propInfo['username4']['username'];
if (isset($_SESSION['username']) && $_SESSION['loggedin'])
{
	$sUser = $_SESSION['username'];
	$isOwner = ($sUser == $u1 || $sUser == $u2 || $sUser == $u3 || $sUser == $u4);
}
else
{
	$isOwner = false;
}

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href='../includes/fonts.css'>
		<link rel="stylesheet" type="text/css" href='../includes/style.css'>
		<title>Edit Proposal</title>
		<script language='javascript' src='../includes/jquery-1.9.1.min.js'></script>
		<script language='javascript' src='../includes/script.js'></script>
	</head>
	<body>
		
		<div id="print">
		  <?php showHeader(); ?>
			<div class="boxes">
				<div class="right_menu">
					<?php showMenu(); ?>
			  </div>
			  
			  <div class="posts">
			  	<div class="box">
				  	<div class="title">نکاتی درباره ی تکمیل فرم</div>
				  	<div class="contents">
				  		<ul>
								<li>قبل از تکمیل فرم،  حتما راهنمای تکمیل پروپوزال را مطالعه فرمایید.</li>
								<li>شما تنها ملزم به پر کردن بخش های سفید هستید، بقیه فیلدها توسط سیستم پر می شوند.</li>
								<li>توصیه میشود حتما از مرورگرهای پیشنهاد شده استفاده کنید.</li>
								<li>مدت زمان تکمیل فرم و مشاهده ی صفحه محدود است.</li>
								<li>قبل از وارد کردن اطلاعات، یک نسخه از آن را نزد خود نگه دارید.</li>
								<li>سیستم تنها آخرین اطلاعات پروژه را نگه میدارد. پس از قبل از به روز رسانی، یک نسخه ی پشتیبان تهیه کنید.</li>
								<li>محدودیت های اعمال شده از قبیل تعداد اعضا، معلمان راهنما، گروه های پژوهشی و تعداد کاراکترها، قابل تغییر نیستند.</li>
								<li>در صورت وارد کردن اطلاعات بیشتر از فضای داده شده، سیستم بخش اضافه را حذف می کند.</li>
							</ul>
				  	</div>
			  	</div>
			  	
			  	<div class="box">
				  	<div class="title">پروپوزال طرح</div>
				  	<div class="contents">
							<form  id='mainForm' action='../includes/IO.php' method="POST">
								<input type="hidden" name="updateForm" value='true'>
									<fieldset form="mainForm">
										<legend>مشخصات طرح</legend>
										<table style="table-layout: fixed;">
											<tr>
												<td align='center'>عنوان طرح:</td>
												<td align='center'><textarea <? if (! $isOwner) echo "readonly "; ?> autofocus required class="small_editable project_title" name="projectTitle" id='projectTitle' maxlength="50" placeholder="عنوان نمونه"> <?   echo $propInfo['title']; ?></textarea></td>
												<td align='center'>کد طرح:</td>
												<td align='center'><textarea readonly name='propID' class='proposal_ID'><?php echo $propInfo['ID']; ?> </textarea></td>
											</tr>
											<tr>
												<td align='right' colspan="2">زمینه ی علمی طرح</td>
												<td align='center' colspan="2">
													<select id='group' name="group">
													<option></option>
													<? foreach($groups as $en => $fa){echo '<option value='.$en.'>'.$fa.'</option>';} ?>
													</select>				
													<?  echo  '<script>setSelector("group", "' . ($propInfo['category']).'") </script>'; ?>
												</td>
											</tr>
										</table>
										</fieldset><br>
									
										<fieldset form="mainForm"><br>
										<legend>مشخصات طراحان</legend>
										<table width="100%">
											<tr>
												<td align='center'>کد ملی طراحان</td>
												<td align='center'><textarea <? if (! $isOwner) echo "readonly "; ?> required name='projectDesigner1' id='projectDesigner1' class="small_editable" maxlength="10" placeholder="0123456789"><?  echo $propInfo['username1']['username'];?></textarea></td>
												<td align='center'><textarea <? if (! $isOwner) echo "readonly "; ?> name='projectDesigner2' id='projectDesigner2' class="small_editable" maxlength="10" placeholder="0123456789"><?  echo $propInfo['username2']['username'];?></textarea></td>
												<td align='center'><textarea <? if (! $isOwner) echo "readonly "; ?> name='projectDesigner3' id='projectDesigner3' class="small_editable" maxlength="10" placeholder="0123456789"><?  echo $propInfo['username3']['username'];?></textarea></td>
												<td align='center'><textarea <? if (! $isOwner) echo "readonly "; ?> name='projectDesigner4' id='projectDesigner4' class="small_editable" maxlength="10" placeholder="0123456789"><?  echo $propInfo['username4']['username'];?></textarea></td>
											</tr>
											<tr height="60">
												<td align='center'>نام طراحان</td>
												<td align='center' style="font-size: 14px;"><?   echo $propInfo['username1']['firstname'].' '.$propInfo['username1']['lastname']; ?></td>
												<td align='center' style="font-size: 14px;"><?   echo $propInfo['username2']['firstname'].' '.$propInfo['username2']['lastname']; ?></td>
												<td align='center' style="font-size: 14px;"><?   echo $propInfo['username3']['firstname'].' '.$propInfo['username3']['lastname']; ?></td>
												<td align='center' style="font-size: 14px;"><?   echo $propInfo['username4']['firstname'].' '.$propInfo['username4']['lastname']; ?></td>	
											</tr>
											<tr>
												<td align='center'>عکس طراحان</td>
												<td align='center'><?  echo '<img  id="profPic1" src="' . $profPicsDir . $propInfo['username1']['username'] . '.jpg"  width="100" height="100" onerror="fixImage(id)">'; ?> </td>
												<td align='center'><?  echo '<img id="profPic2" src="' . $profPicsDir . $propInfo['username2']['username'] . '.jpg"  width="100" height="100" onerror="fixImage(id)">'; ?> </td>
												<td align='center'><?  echo '<img id="profPic3" src="' . $profPicsDir . $propInfo['username3']['username'] . '.jpg"  width="100" height="100" onerror="fixImage(id)">'; ?> </td>
												<td align='center'><?  echo '<img id="profPic4" src="' . $profPicsDir . $propInfo['username4']['username'] . '.jpg" width="100" height="100" onerror="fixImage(id)">'; ?> </td>
											</tr>
											
										</table>
									</fieldset><br>
									
									<fieldset form="mainForm">
										<legend>مشخصات اساتید راهنما</legend>
										<table width="100%">
											<tr>
												<td align='center'>کد ملی اساتید راهنما</td>
												<td align='center'><textarea <? if (! $isOwner) echo "readonly "; ?> name='projectLeader1' id='projectLeader1' class="small_editable" maxlength="10" placeholder="0123456789"><?  echo $propInfo['teacher1']['username'];?></textarea></td>
												<td align='center'><textarea <? if (! $isOwner) echo "readonly "; ?> name='projectLeader2' id='projectLeader2' class="small_editable" maxlength="10" placeholder="0123456789"><?  echo $propInfo['teacher2']['username'];?></textarea></td>
											</tr>
											<tr height="60">
												<td align='center'>نام اساتید راهنما</td>
												<td align='center' style="font-size: 14px;"><?   echo $propInfo['teacher1']['firstname'].' '.$propInfo['teacher1']['lastname']; ?></td>
												<td align='center' style="font-size: 14px;"><?   echo $propInfo['teacher2']['firstname'].' '.$propInfo['teacher2']['lastname']; ?></td>
											</tr>
										</table>
									</fieldset><br>
									
									<fieldset form="mainForm">
										<legend>چکیده ی طرح</legend>
										<table>
											<tr><td><label>مقدمه</label></td>
												<tr><td><textarea <? if (! $isOwner) echo "readonly "; ?> name='preface' name='preface' id='preface' class="large_editable" placeholder="متن مقدمه ی طرح"><?   echo $propInfo['preface']; ?></textarea>
											<hr></td></tr>
											
											<tr><td><label>مشکل و مسئله ی اصلی</label></td></tr>
												<tr><td><textarea <? if (! $isOwner) echo "readonly "; ?> name='problem' id='problem' class="large_editable" placeholder="بیان مشکل و مسئله ی اصلی"><?   echo $propInfo['problem']; ?></textarea>
											<hr></td></tr>
											
											<tr><td><label>راه حل های موجود برای حل مشکل</label></td></tr>
												<tr><td><textarea <? if (! $isOwner) echo "readonly "; ?> name="solutions" id='solutions' class="large_editable" placeholder="بیان راه حل های موجود برای حل مشکل"><?   echo $propInfo['solutions']; ?></textarea>
											<hr></td></tr>
											
											<tr><td><label>راه حل ما برای حل مشکل</label></td></tr>
												<tr><td><textarea <? if (! $isOwner) echo "readonly "; ?> name="ourSolution" id='ourSolution' class="large_editable" placeholder="بیان راه حل خود برای حل مشکل"><?   echo $propInfo['oursolution']; ?></textarea>
											<hr></td></tr>
											
											<tr><td><label>مزایای طرح</label></td></tr>
												<tr><td><textarea <? if (! $isOwner) echo "readonly "; ?> name="benefits" id='benefits' class="large_editable" placeholder="بیان برتری های طرح خود"><?   echo $propInfo['benefits']; ?></textarea>
											<hr></td></tr>
											
											<tr><td><label>اهداف ما</label></td></tr>
												<tr><td><textarea <? if (! $isOwner) echo "readonly "; ?> name="goals" id='goals' class="large_editable" placeholder="بیان اهداف"><?   echo $propInfo['goals']; ?></textarea>
											<hr></td></tr>
											
											<tr><td><label>کاربردهای طرح</label></td></tr>
												<tr><td><textarea <? if (! $isOwner) echo "readonly "; ?> name="usages" id='usages' class="large_editable" placeholder="بیان کاربردهای طرح"><?   echo $propInfo['usages']; ?></textarea>
											<hr></td></tr>			
													
											<tr><td><label>ابزار و وسایل مورد نیاز برای پروژه</label></td></tr>
												<tr><td><textarea <? if (! $isOwner) echo "readonly "; ?> name="needs" id='needs' class="large_editable" placeholder="بیان امکانات مورد نیاز"><?   echo $propInfo['needs']; ?></textarea>
											<hr></td></tr>
											
											<tr><td align='center'><label>تاریخ شروع طرح</label>
												<select id='startDay' name="startDay">
												<? for($i=1; $i<=31; $i++){echo '<option value='.$i.'>'.$i.'</option>';} ?>
												</select>
												<?  echo  '<script>setSelector("startDay", ' . ($propInfo['startDay']).') </script>'; ?>
												
												<select id='startMonth' name="startMonth">
												<? for($i=1; $i<=12; $i++){echo '<option value='.$i.'>'.$i.'</option>';} ?>
												</select>
												<?  echo  '<script>setSelector("startMonth", ' . ($propInfo['startMonth']).') </script>'; ?>
												
												<select id='startYear' name="startYear">>
												<? for($i=1391; $i<=1392; $i++){echo '<option value='.$i.'>'.$i.'</option>';} ?>
												</select>
												<?  echo  '<script>setSelector("startYear", ' . ($propInfo['startYear']).') </script>'; ?>
												
												
												<label>تاریخ اتمام طرح</label>
												<select id='finishDay' name="finishDay">>
												<? for($i=1; $i<=31; $i++){echo '<option value='.$i.'>'.$i.'</option>';} ?>				
												</select>
												<?  echo  '<script>setSelector("finishDay", ' . ($propInfo['endDay']).') </script>'; ?>
												
												<select id='finishMonth'name="finishMonth">>
												<? for($i=1; $i<=12; $i++){echo '<option value='.$i.'>'.$i.'</option>';} ?>
												</select>
												<?  echo  '<script>setSelector("finishMonth", ' . ($propInfo['endMonth']).') </script>'; ?>
												
												<select id='finishYear' name="finishYear">
												<? for($i=1391; $i<=1393; $i++){echo '<option value='.$i.'>'.$i.'</option>';} ?>
												</select>
												<?  echo  '<script>setSelector("finishYear", ' . ($propInfo['endYear']).') </script>'; ?>
												
												<hr>
											</td></tr>
											<tr><td><label>توضیحات بیشتر</label></td></tr>
												<tr><td><textarea <? if (! $isOwner) echo "readonly "; ?> name='comments' id='comments' class="large_editable" placeholder="ارائه ی توضیحات بیشتر درباره ی طرح"><?   echo $propInfo['othercomments']; ?></textarea>
											<hr></td></tr>
											
											<tr><td><label>نتیجه گیری</label></td></tr>
												<tr><td><textarea <? if (! $isOwner) echo "readonly "; ?> name='conclusion' id='conclusion' class="large_editable" placeholder='نتیجه گیری نهایی'><?   echo $propInfo['conclusion']; ?></textarea>
											<hr></td></tr>
										</table>
									</fieldset>
									<br>
									<center>
										<?
											if ($isOwner)
												echo 
													"<button class='green_button' type='submit'>ثبت طرح</button>
													<button class='white_button' type='reset' style='height: 25px;'>پاک کردن فرم</button>";
										?>
										<button class='orange_button' type='button' style='height: 25px;' onclick="window.location = '../user/user.php'">بازگشت</button>
									</center>
							</form>
							<form method="post" action="../includes/IO.php">
								<center>
									<input type="hidden" name="delete_proposal" value="true">
									<?
										if ($isOwner)
											echo "<button class='red_button' style='height: 25px;'>حذف طرح</button>";
									?>
								</center>
							</form>
				  	</div>
					</div>
					
					<!-- <div class="box">
				  	<div class="title">نکات قابل توجه</div>
				  	<div class="contents">
					  	<ul>
								<li>در صورت مشاهده ایراد در سیستم، پس از مدتی صبر دوباره تلاش کنید و سپس مسولین سیستم را مطلع کنید.</li>
								<li>در زمان های مشخص تعمیر سیستم، از تغییر اطلاعات خودداری نمایید.</li>
							</ul>
				  	</div>
					</div> -->
					
			  </div>
		  </div>
			<?php showFooter(); ?>	  
	  </div>		
		
	</body>
</html>
