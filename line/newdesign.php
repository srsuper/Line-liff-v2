
<!DOCTYPE html>
<!-- Load theme options -->

<!-- Load theme functions -->

	<html>
	<head>
		<meta charset="utf-8" />
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title>มุมสำหรับสมาชิก - Metrabyte.Cloud</title>
		<!-- Styling -->
	<link rel="stylesheet" href="/hosting/templates/control/css/main.min.css?v=820e18">
<!-- Custom Styling -->
<link rel="stylesheet" href="/hosting/templates/control/css/custom.css">
<!-- JS -->
<script type="text/javascript">
    var csrfToken = 'f789f0758e9085f16dfa8cb3de431ff3aad89042',
        markdownGuide = 'Markdown Guide',
        locale = 'en',
        saved = 'saved',
        saving = 'autosaving';
</script>
<script src="/hosting/templates/control/js/scripts.min.js?v=820e18"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- Custom Fonts -->
<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900,300italic,400italic,600italic,700italic,900italic" rel="stylesheet" type="text/css">
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">


		<!-- WHMCS head Output -->
		


	</head>
	<body class="off-canvas clientareahome green">
		<!-- WHMCS header Output -->
		
		<!-- Display brand and main nav bar -->
		<div id="container">
			<header id="header" >
				<!--logo start-->
									<div class="brand">
						<!-- Display brand -->
						<!-- Show navbar brand -->
                        	<a class="logo logotext" target ="_blank" href="https://metrabyte.cloud/">Metrabyte.Cloud</a>
            
					</div>
								<!--logo end-->
									<div class="toggle-navigation toggle-left">
						<button type="button" class="btn btn-default" id="toggle-left">
							<i class="fa fa-bars"></i>
						</button>
					</div>
								<div class="user-nav">
					<ul>
						<!-- Display Desktop Shopping Cart Link, if enabled -->
													<li id="carticondesk" class="dropdown messages ">
								<span class="badge badge-primary animated bounceIn" id="cartItemCount">0</span>
								<button type="button" class="btn btn-default options" id="cart-link" onclick="window.location.assign('/hosting/cart.php?a=view')">
									<i class="fa fa-shopping-cart"></i>
								</button>
							</li>
												<!-- Display Desktop Account Notifications, if enabled -->
																					<li class="dropdown messages ">
									<span class="badge badge-danager animated bounceIn">2</span>
									<button type="button" class="btn btn-default options" data-toggle="dropdown" id="accountNotifications2" data-placement="bottom">
										<i class="fa fa-exclamation-triangle"></i>
									</button>
									<ul class="dropdown-menu alert animated fadeInDown">
										<li>
											<div class="header"><strong>2</strong> Notifications</div>
										</li>
																					<li>
												<div class="message-content text-info">You have 3 unpaid invoice(s). Pay them early for peace of mind. <a href="clientarea.php?action=masspay&all=true" class="btn btn-xs btn-info">ชำระค่าบริการเดี๋ยวนี้</a></div>
											</li>
																					<li>
												<div class="message-content text-warning">You have 2 overdue invoice(s) with a total balance due of 1,057.93 บาท. Pay them now to avoid any interuptions in service. <a href="clientarea.php?action=masspay&all=true" class="btn btn-xs btn-warning">ชำระค่าบริการเดี๋ยวนี้</a></div>
											</li>
																			</ul>
								</li>
																			<!-- Display Desktop Header Language Chooser, if enabled -->
                                                                            						    <li menuItemName="Account" class="dropdown settings account" id="Secondary_Navbar-Account">
		<button type="button" class="btn btn-default dropdown-toggle options" id="toggle-user" data-toggle="dropdown">
			<i class="fa fa-user"></i>
		</button>
        <a class="dropdown-toggle hidden-xs" data-toggle="dropdown" href="#">
                        Hello, ยุทธชัย!
                        &nbsp;<b class="caret"></b>        </a>
                    <ul class="dropdown-menu dropdown-menu-right animated fadeInDown">
                            <li menuItemName="Edit Account Details" id="Secondary_Navbar-Account-Edit_Account_Details">
                    <a href="/hosting/clientarea.php?action=details">
                        <i class="fa fa-edit fa-fw"></i>&nbsp;
						                        Edit Account Details
                                            </a>
                </li>
                            <li menuItemName="Contacts/Sub-Accounts" id="Secondary_Navbar-Account-Contacts_Sub-Accounts">
                    <a href="/hosting/clientarea.php?action=contacts">
                        <i class="fa fa-book fa-fw"></i>&nbsp;
						                        จัดการที่อยู่ติดต่อ
                                            </a>
                </li>
                            <li menuItemName="Change Password" id="Secondary_Navbar-Account-Change_Password">
                    <a href="/hosting/clientarea.php?action=changepw">
                        <i class="fa fa-key fa-fw"></i>&nbsp;
                                                เปลี่ยนรหัสผ่าน
                                            </a>
                </li>
                            <li menuItemName="Email History" id="Secondary_Navbar-Account-Email_History">
                    <a href="/hosting/clientarea.php?action=emails">
                        <i class="fa fa-envelope-o fa-fw"></i>&nbsp;
						                        ประวัติอีเมล์
                                            </a>
                </li>
                            <li menuItemName="Divider" class="nav-divider" id="Secondary_Navbar-Account-Divider">
                    <a href="">
                        <i class="fa fa-angle-right fa-fw"></i>&nbsp;
						                        -----
                                            </a>
                </li>
                            <li menuItemName="Logout" id="Secondary_Navbar-Account-Logout">
                    <a href="/hosting/logout.php">
                        <i class="fa fa-sign-out fa-fw"></i>&nbsp;
						                        ออกจากระบบ
                                            </a>
                </li>
                        </ul>
            </li>

					</ul>
				</div>
			</header>
            <div class="flex-wrap">
                                    <!--sidebar left start-->
                    <nav class="sidebar sidebar-left">
                        <ul class="nav nav-pills nav-stacked">
                            																		    <li menuItemName="Home" class="active " id="Primary_Navbar-Home">
    	<a href="/hosting/clientarea.php">
            <i class="fa fa-home fa-fw"></i>&nbsp;
			            หน้าแรก
                 
        </a>
            </li>
											    <li menuItemName="Services" class="nav-dropdown" id="Primary_Navbar-Services">
    	<a href="#">
            <i class="fa fa-tasks fa-fw"></i>&nbsp;
			            บริการของฉัน
                 
        </a>
                    <ul class="nav-sub">
            																												                                                <li menuItemName="My Services" class="" id="Primary_Navbar-Services-My_Services">
                    <a href="/hosting/clientarea.php?action=services">
                                                บริการของฉัน
                                            </a>
                </li>
            																	                                                <li menuItemName="Services Divider" class=" nav-divider" id="Primary_Navbar-Services-Services_Divider">
                    <a href="">
                                                -----
                                            </a>
                </li>
            																												                                                <li menuItemName="Order New Services" class="" id="Primary_Navbar-Services-Order_New_Services">
                    <a href="/hosting/cart.php">
                                                สั่งซื้อบริการใหม่
                                            </a>
                </li>
            																												                                                <li menuItemName="View Available Addons" class="" id="Primary_Navbar-Services-View_Available_Addons">
                    <a href="/hosting/cart.php?gid=addons">
                                                แสดงบริการเสริม
                                            </a>
                </li>
                        </ul>
            </li>
											    <li menuItemName="Domains" class="nav-dropdown" id="Primary_Navbar-Domains">
    	<a href="#">
            <i class="fa fa-link fa-fw"></i>&nbsp;
			            โดเมน
                 
        </a>
                    <ul class="nav-sub">
            																												                                                <li menuItemName="My Domains" class="" id="Primary_Navbar-Domains-My_Domains">
                    <a href="/hosting/clientarea.php?action=domains">
                                                โดเมนของฉัน
                                            </a>
                </li>
            																	                                                <li menuItemName="Domains Divider" class=" nav-divider" id="Primary_Navbar-Domains-Domains_Divider">
                    <a href="">
                                                -----
                                            </a>
                </li>
            																												                                                <li menuItemName="Renew Domains" class="" id="Primary_Navbar-Domains-Renew_Domains">
                    <a href="/hosting/cart.php?gid=renewals">
                                                ต่ออายุโดเมน
                                            </a>
                </li>
            																	                						                                                <li menuItemName="Register a New Domain" class="" id="Primary_Navbar-Domains-Register_a_New_Domain">
                    <a href="/hosting/cart.php?a=add&domain=register">
                                                จดทะเบียนโดเมนเนมใหม่
                                            </a>
                </li>
            																	                                                                                    <li menuItemName="Transfer a Domain to Us" class="" id="Primary_Navbar-Domains-Transfer_a_Domain_to_Us">
                    <a href="/hosting/cart.php?a=add&domain=transfer">
                                                ย้ายโดเมนมาอยู่กับเรา
                                            </a>
                </li>
            																	                                                <li menuItemName="Domains Divider 2" class=" nav-divider" id="Primary_Navbar-Domains-Domains_Divider_2">
                    <a href="">
                                                -----
                                            </a>
                </li>
            																												                                                <li menuItemName="Domain Search" class="" id="Primary_Navbar-Domains-Domain_Search">
                    <a href="/hosting/domainchecker.php">
                                                ค้นหาโดเมน
                                            </a>
                </li>
                        </ul>
            </li>
											    <li menuItemName="Billing" class="nav-dropdown" id="Primary_Navbar-Billing">
    	<a href="#">
            <i class="fa fa-money fa-fw"></i>&nbsp;
			            การชำระเงิน
                 
        </a>
                    <ul class="nav-sub">
            																												                                                <li menuItemName="My Invoices" class="" id="Primary_Navbar-Billing-My_Invoices">
                    <a href="/hosting/clientarea.php?action=invoices">
                                                ใบแจ้งค่าบริการของฉัน
                                            </a>
                </li>
            																												                                                <li menuItemName="My Quotes" class="" id="Primary_Navbar-Billing-My_Quotes">
                    <a href="/hosting/clientarea.php?action=quotes">
                                                My Quotes
                                            </a>
                </li>
            																	                                                <li menuItemName="Billing Divider" class=" nav-divider" id="Primary_Navbar-Billing-Billing_Divider">
                    <a href="">
                                                -----
                                            </a>
                </li>
            																												                                                <li menuItemName="Mass Payment" class="" id="Primary_Navbar-Billing-Mass_Payment">
                    <a href="/hosting/clientarea.php?action=masspay&all=true">
                                                Mass Payment
                                            </a>
                </li>
                        </ul>
            </li>
											    <li menuItemName="Support" class="nav-dropdown" id="Primary_Navbar-Support">
    	<a href="#">
            <i class="fa fa-life-ring fa-fw"></i>&nbsp;
			            บริการลูกค้า
                 
        </a>
                    <ul class="nav-sub">
            																												                                                <li menuItemName="Tickets" class="" id="Primary_Navbar-Support-Tickets">
                    <a href="/hosting/supporttickets.php">
                                                ปัญหาการใช้งาน
                                            </a>
                </li>
            																												                                                <li menuItemName="Announcements" class="" id="Primary_Navbar-Support-Announcements">
                    <a href="/hosting/announcements">
                                                ประกาศจากทีมงาน
                                            </a>
                </li>
            																												                                                <li menuItemName="Knowledgebase" class="" id="Primary_Navbar-Support-Knowledgebase">
                    <a href="/hosting/knowledgebase">
                                                คู่มือการใช้งาน
                                            </a>
                </li>
            																												                                                <li menuItemName="Downloads" class="" id="Primary_Navbar-Support-Downloads">
                    <a href="/hosting/download">
                                                ดาวน์โหลด
                                            </a>
                </li>
            																			                    				                                                <li menuItemName="Network Status" class="" id="Primary_Navbar-Support-Network_Status">
                    <a href="/hosting/serverstatus.php">
                                                สถานะเน็ตเวิรค์
                                            </a>
                </li>
                        </ul>
            </li>
											    <li menuItemName="Open Ticket" class="" id="Primary_Navbar-Open_Ticket">
    	<a href="/hosting/submitticket.php">
            <i class="fa fa-comment fa-fw"></i>&nbsp;
			            แจ้งปัญหาการใช้งาน
                 
        </a>
            </li>
<li menuitemname="Contact Us" class="" id="Primary_Navbar-Contact_Us">
    	<a target ="_blank" href="https://metrabyte.cloud/confirm.php">
            <i class="fa fa-money fa-fw"></i>&nbsp;
			            แจ้งชำระเงิน
                 
        </a>
            </li>

                        </ul>
                    </nav>
                    <!--sidebar left end-->
                                <!--main content start-->
                <section class="main-content-wrapper">
                    <!-- If page isn't shopping cart, display page header, feat content, and setup main content and sidebar layout -->
                                            <section id="main-content">
                            <!-- Display page title -->
                            
                            
                                                        <!-- Display featured content section (if applicable) -->
                                                            

					<!--tiles start-->
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<a href="clientarea.php?action=invoices">
						<div class="dashboard-tile detail tile-red">
							<div class="content">
								<h1 class="text-left timer" data-from="0" data-to="3" data-speed="2500"> </h1>
								<p>รายการชำระเงิน</p>
							</div>
							<div class="icon"><i class="fa fa-warning"></i>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-3 col-sm-6">
					<a href="clientarea.php?action=products">
						<div class="dashboard-tile detail tile-turquoise">
							<div class="content">
								<h1 class="text-left timer" data-from="0" data-to="1" data-speed="2500"> </h1>
								<p>บริการของฉัน</p>
							</div>
							<div class="icon"><i class="fa fa-tasks"></i>
							</div>
						</div>
					</a>
				</div>
									<div class="col-md-3 col-sm-6">
						<a href="clientarea.php?action=domains">
							<div class="dashboard-tile detail tile-blue">
								<div class="content">
									<h1 class="text-left timer" data-from="0" data-to="2" data-speed="2500"> </h1>
									<p>โดเมน</p>
								</div>
								<div class="icon"><i class="fa fa fa-link"></i>
								</div>
							</div>
						</a>
					</div>
								<div class="col-md-3 col-sm-6">
					<a href="supporttickets.php">
						<div class="dashboard-tile detail tile-purple">
							<div class="content">
								<h1 class="text-left timer" data-to="0" data-speed="2500"> </h1>
								<p>คำถามของคุณ</p>
							</div>
							<div class="icon"><i class="fa fa-inbox"></i>
							</div>
						</div>
					</a>
				</div>
			</div>
			<!--tiles end-->
		
                                                        <!-- Display sidebar layout if applicable -->
                                                            <div class="row">
                                                                            <div class="col-md-3 pull-md-right whmcs-sidebar sidebar-primary">
                                            		<div menuItemName="Client Details" class="panel panel-default">
		<div class="panel-heading">
							<h3 class="panel-title">
					<i class="fa fa-user"></i>&nbsp;					Your Info
														</h3>
					</div>
					<div class="panel-body">
				<strong>ยุทธชัย ทองคำชุม</strong><br>15/01/2018<br>Rat Burana<br>500, ธ.กรุงเทพ, 10825<br>Thailand</p>
			</div>
									<div class="panel-footer clearfix">
				    <a href="clientarea.php?action=details" class="btn btn-success btn-sm btn-block">
        <i class="fa fa-pencil"></i> Update
    </a>
			</div>
			</div>
	
                                        </div>
                                                                        <div id="internal-content" class="col-md-9 pull-md-left">
                                                        <!-- Display custom module wrapper if applicable -->
                                                

<div class="client-home-panels">
	<div class="row">
		<div class="col-sm-6">
			
																<div menuItemName="Overdue Invoices" class="panel panel-default panel-accent-red">
					<div class="panel-heading">
						<h3 class="panel-title">
															<div class="pull-right">
									<a href="clientarea.php?action=masspay&all=true" class="btn btn-default bg-color-red btn-xs">
										<i class="fa fa-arrow-right"></i>										ชำระค่าบริการเดี๋ยวนี้
									</a>
								</div>
														<i class="fa fa-calculator"></i>&nbsp;							Overdue Invoices
													</h3>
					</div>
											<div class="panel-body">
							<p>You have 2 overdue invoice(s) with a total balance due of 1,057.93 บาท. Pay them now to avoid any interruptions in service.</p>
						</div>
																			</div>
			
																											<div menuItemName="Recent Support Tickets" class="panel panel-default panel-accent-blue">
					<div class="panel-heading">
						<h3 class="panel-title">
															<div class="pull-right">
									<a href="submitticket.php" class="btn btn-default bg-color-blue btn-xs">
										<i class="fa fa-plus"></i>										Open New Ticket
									</a>
								</div>
														<i class="fa fa-comments"></i>&nbsp;							Recent Support Tickets
													</h3>
					</div>
											<div class="panel-body">
							<p>No Recent Tickets Found. If you need any help, please <a href="submitticket.php">open a ticket</a>.</p>
						</div>
																			</div>
			
																											<div menuItemName="Recent News" class="panel panel-default panel-accent-asbestos">
					<div class="panel-heading">
						<h3 class="panel-title">
															<div class="pull-right">
									<a href="/hosting/announcements" class="btn btn-default bg-color-asbestos btn-xs">
										<i class="fa fa-arrow-right"></i>										View All
									</a>
								</div>
														<i class="fa fa-newspaper-o"></i>&nbsp;							Recent News
													</h3>
					</div>
																<div class="list-group">
																								<a menuItemName="0" href="/hosting/announcements/3/-UXorUI-.html" class="list-group-item" id="ClientAreaHomePagePanels-Recent_News-0">
																				แจ้งปรับปรุง UX/UI ส่วนบริการค้าใหม่<br /><span class="text-last-updated">28/10/2017</span>
																			</a>
																																<a menuItemName="1" href="/hosting/announcements/2/----.html" class="list-group-item" id="ClientAreaHomePagePanels-Recent_News-1">
																				แจ้งเปลี่ยนแปลงโครงสร้าง บริษัท เมทราไบต์ คลาวด์ จำกัด<br /><span class="text-last-updated">04/04/2017</span>
																			</a>
																																<a menuItemName="2" href="/hosting/announcements/1" class="list-group-item" id="ClientAreaHomePagePanels-Recent_News-2">
																				แจ้งเปลี่ยนอีเมล์และเบอร์โทรติดต่อ<br /><span class="text-last-updated">04/04/2017</span>
																			</a>
																					</div>
														</div>
			
									</div>
		<div class="col-sm-6">
																							<div menuItemName="Active Products/Services" class="panel panel-default panel-accent-gold">
					<div class="panel-heading">
						<h3 class="panel-title">
															<div class="pull-right">
									<a href="clientarea.php?action=services" class="btn btn-default bg-color-gold btn-xs">
										<i class="fa fa-plus"></i>										View All
									</a>
								</div>
														<i class="fa fa-cube"></i>&nbsp;							Your Active Products/Services
													</h3>
					</div>
																<div class="list-group">
																								<a menuItemName="0" href="/hosting/clientarea.php?action=productdetails&id=13151" class="list-group-item" id="ClientAreaHomePagePanels-Active_Products_Services-0">
																				Cloud VPS Windows SSD - Cloud VPS Windows SSD 3 @ Ram 4 Gb<br /><span class="text-domain">Windows13151</span>
																			</a>
																					</div>
														</div>
			
																											<div menuItemName="Register a New Domain" class="panel panel-default panel-accent-emerald">
					<div class="panel-heading">
						<h3 class="panel-title">
														<i class="fa fa-globe"></i>&nbsp;							จดทะเบียนโดเมนเนมใหม่
													</h3>
					</div>
											<div class="panel-body">
							<form method="post" action="domainchecker.php">
<input type="hidden" name="token" value="f789f0758e9085f16dfa8cb3de431ff3aad89042" />
            <div class="input-group margin-10">
                <input type="text" name="domain" class="form-control" />
                <div class="input-group-btn">
                    <input type="submit" value="จดใหม่" class="btn btn-success" />
                    <input type="submit" name="transfer" value="ย้าย" class="btn" />
                </div>
            </div>
        </form>
						</div>
																			</div>
			
																</div>
	</div>
</div>


                        <!-- If page isn't shopping cart, close main content layout and display secondary sidebar (if enabled and applicable) -->
                                                    <!-- Display custom module wrapper if applicable -->
                                                        <!-- Close main content layout and display secondary sidebar (if enabled and applicable) -->
                                                                </div>
                                                                            <div class="col-md-3 pull-md-right whmcs-sidebar sidebar-secondary">
                                            	<div menuItemName="Client Contacts" class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<i class="fa fa-folder-o"></i>&nbsp;				Contacts
							</h3>
		</div>
							<div class="list-group">
															<div menuItemName="No Contacts" class="list-group-item" id="Secondary_Sidebar-Client_Contacts-No_Contacts">
																					No Contacts Found
						</div>
												</div>
							<div class="panel-footer clearfix">
				    <a href="clientarea.php?action=addcontact" class="btn btn-default btn-sm btn-block">
        <i class="fa fa-plus"></i> New Contact...
    </a>
			</div>
			</div>
		<div menuItemName="Client Shortcuts" class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<i class="fa fa-bookmark"></i>&nbsp;				Shortcuts
							</h3>
		</div>
							<div class="list-group">
															<a menuItemName="Order New Services" href="/hosting/cart.php" class="list-group-item" id="Secondary_Sidebar-Client_Shortcuts-Order_New_Services">
														<i class="fa fa-shopping-cart fa-fw"></i>&nbsp;							สั่งซื้อบริการใหม่
						</a>
																				<a menuItemName="Register New Domain" href="/hosting/domainchecker.php" class="list-group-item" id="Secondary_Sidebar-Client_Shortcuts-Register_New_Domain">
														<i class="fa fa-globe fa-fw"></i>&nbsp;							จดทะเบียนโดเมนเนม
						</a>
																				<a menuItemName="Logout" href="/hosting/logout.php" class="list-group-item" id="Secondary_Sidebar-Client_Shortcuts-Logout">
														<i class="fa fa-arrow-left fa-fw"></i>&nbsp;							ออกจากระบบ
						</a>
												</div>
					</div>
	
                                        </div>
                                                                    </div>
                                                        <div class="clearfix"></div>
                        </section>
                    				</div>
				<!-- If theme debug is enabled, display function variables for test and debugging purposes -->
								<div id="footer" class="panel panel-solid-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-7">
								<span class="footer-text">Copyright &copy; 2020 Metrabyte.Cloud. All Rights Reserved.</span>
							</div>
							<div class="col-sm-5">
								<div class="row">
									<div class="col-xs-10 text-right lang-ft">
																					<a href="#bottom" data-toggle="popover" id="languageChooser3"><i class="fa fa-globe"></i> ไทย</a>
																			</div>
									<div class="col-xs-2 text-right">
										<a href="#top"><i class="fa fa-angle-up fa-2x"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="languageChooserContent" class="hidden">
					<ul>
				                                   <li><a href="/hosting/clientarea.php?language=chinese">中文</a></li>
                                                   <li><a href="/hosting/clientarea.php?language=english">English</a></li>
                                                   <li><a href="/hosting/clientarea.php?language=russian">Русский</a></li>
                                                   <li><a href="/hosting/clientarea.php?language=thai">ไทย</a></li>
                        					</ul>
				</div>
			</section>
		</div>
		
			<script>
				$(document).ready(function() {
					app.timer();
				});
				$('a[href="#top"]').click(function(){
					$('html, body').animate({scrollTop:0}, 'slow');
				});
			</script>
		
		<div class="modal system-modal fade" id="modalAjax" tabindex="-1" role="dialog" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content panel panel-primary">
		            <div class="modal-header panel-heading">
		                <button type="button" class="close" data-dismiss="modal">
		                    <span aria-hidden="true">&times;</span>
		                    <span class="sr-only">Close</span>
		                </button>
		                <h4 class="modal-title">Title</h4>
		            </div>
		            <div class="modal-body panel-body">
		                Loading...
		            </div>
		            <div class="modal-footer panel-footer">
		                <div class="pull-left loader">
		                    <i class="fa fa-circle-o-notch fa-spin"></i> Loading...
		                </div>
		                <button type="button" class="btn btn-default" data-dismiss="modal">
		                    Close
		                </button>
		                <button type="button" class="btn btn-primary modal-submit">
		                    Submit
		                </button>
		            </div>
		        </div>
		    </div>
		</div>
		
	</body>
</html>