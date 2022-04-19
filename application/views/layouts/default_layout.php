<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>irotore - <?php echo $title;?></title>
        <link href="<?php echo base_url();?>assets/css/styles.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>assets/css/customStyle.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
    </head>
    <body class="nav-fixed">
        <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light brand-background" id="sidenavAccordion">
            <!-- Navbar Brand-->
            <!-- * * Tip * * You can use text or an image for your navbar brand.-->
            <!-- * * * * * * When using an image, we recommend the SVG format.-->
            <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px Zero Store-logos_white-small.png-->
            <a class="navbar-brand text-white" href="<?php echo base_url()?>" >
                <div style="float: left;" class="cir">ZS</div>
                <p style="font-size: 10px; float: left; vertical-align: middle; padding-left: 8px; padding-top: 16px;"><?php  echo !(empty($this->session->userdata('firmname'))) ? $this->session->userdata('firmname') : '';
                ?></p>
            </a>
            
            <!-- Sidenav Toggle Button-->
            <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle"><i data-feather="menu"></i></button>
            <!-- Navbar Search Input-->
            <!-- * * Note: * * Visible only on and above the md breakpoint-->
            <!-- <form class="form-inline mr-auto d-none d-md-block mr-3">
                <div class="input-group input-group-joined input-group-solid">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" />
                    <div class="input-group-append">
                        <div class="input-group-text"><i data-feather="search"></i></div>
                    </div>
                </div>
            </form> -->
            <!-- Navbar Items-->
            <ul class="navbar-nav align-items-center ml-auto">
                <!-- Documentation Dropdown-->
                <li class="nav-item dropdown no-caret d-none d-sm-block mr-3">
                    <!-- <a class="nav-link dropdown-toggle" id="navbarDropdownDocs" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="font-weight-500">Documentation</div>
                        <i class="fas fa-chevron-right dropdown-arrow"></i>
                    </a> -->
                    <div class="dropdown-menu dropdown-menu-right py-0 mr-sm-n15 mr-lg-0 o-hidden animated--fade-in-up" aria-labelledby="navbarDropdownDocs">
                        <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro" target="_blank">
                            <div class="icon-stack bg-primary-soft text-primary mr-4"><i data-feather="book"></i></div>
                            <div>
                                <div class="small text-gray-500">Documentation</div>
                                Usage instructions and reference
                            </div>
                        </a>
                        <div class="dropdown-divider m-0"></div>
                        <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro/components" target="_blank">
                            <div class="icon-stack bg-primary-soft text-primary mr-4"><i data-feather="code"></i></div>
                            <div>
                                <div class="small text-gray-500">Components</div>
                                Code snippets and reference
                            </div>
                        </a>
                        <div class="dropdown-divider m-0"></div>
                        <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro/changelog" target="_blank">
                            <div class="icon-stack bg-primary-soft text-primary mr-4"><i data-feather="file-text"></i></div>
                            <div>
                                <div class="small text-gray-500">Changelog</div>
                                Updates and changes
                            </div>
                        </a>
                    </div>
                </li>
                <!-- Navbar Search Dropdown-->
                <!-- * * Note: * * Visible only below the md breakpoint-->
                <li class="nav-item dropdown no-caret mr-3 d-md-none">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="searchDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="search"></i></a>
                    <!-- Dropdown - Search-->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--fade-in-up" aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100">
                            <div class="input-group input-group-joined input-group-solid">
                                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                                <div class="input-group-append">
                                    <div class="input-group-text"><i data-feather="search"></i></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- Alerts Dropdown-->
                <li class="nav-item dropdown no-caret d-none d-sm-block mr-3 dropdown-notifications">
                    <!-- <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="bell"></i></a> -->
                    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
                        <h6 class="dropdown-header dropdown-notifications-header">
                            <i class="mr-2" data-feather="bell"></i>
                            Alerts Center
                        </h6>
                        <!-- Example Alert 1-->
                        <a class="dropdown-item dropdown-notifications-item" href="#!">
                            <div class="dropdown-notifications-item-icon bg-warning"><i data-feather="activity"></i></div>
                            <div class="dropdown-notifications-item-content">
                                <div class="dropdown-notifications-item-content-details">December 29, 2020</div>
                                <div class="dropdown-notifications-item-content-text">This is an alert message. It's nothing serious, but it requires your attention.</div>
                            </div>
                        </a>
                        <!-- Example Alert 2-->
                        <a class="dropdown-item dropdown-notifications-item" href="#!">
                            <div class="dropdown-notifications-item-icon bg-info"><i data-feather="bar-chart"></i></div>
                            <div class="dropdown-notifications-item-content">
                                <div class="dropdown-notifications-item-content-details">December 22, 2020</div>
                                <div class="dropdown-notifications-item-content-text">A new monthly report is ready. Click here to view!</div>
                            </div>
                        </a>
                        <!-- Example Alert 3-->
                        <a class="dropdown-item dropdown-notifications-item" href="#!">
                            <div class="dropdown-notifications-item-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></div>
                            <div class="dropdown-notifications-item-content">
                                <div class="dropdown-notifications-item-content-details">December 8, 2020</div>
                                <div class="dropdown-notifications-item-content-text">Critical system failure, systems shutting down.</div>
                            </div>
                        </a>
                        <!-- Example Alert 4-->
                        <a class="dropdown-item dropdown-notifications-item" href="#!">
                            <div class="dropdown-notifications-item-icon bg-success"><i data-feather="user-plus"></i></div>
                            <div class="dropdown-notifications-item-content">
                                <div class="dropdown-notifications-item-content-details">December 2, 2020</div>
                                <div class="dropdown-notifications-item-content-text">New user request. Woody has requested access to the organization.</div>
                            </div>
                        </a>
                        <a class="dropdown-item dropdown-notifications-footer" href="#!">View All Alerts</a>
                    </div>
                </li>
                <!-- Messages Dropdown-->
                <li class="nav-item dropdown no-caret d-none d-sm-block mr-3 dropdown-notifications">
                    <!-- <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownMessages" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="mail"></i></a> -->
                    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownMessages">
                        <h6 class="dropdown-header dropdown-notifications-header">
                            <i class="mr-2" data-feather="mail"></i>
                            Message Center
                        </h6>
                        <!-- Example Message 1  -->
                        <a class="dropdown-item dropdown-notifications-item" href="#!">
                            <img class="dropdown-notifications-item-img" src="<?php echo base_url('assets/img/illustrations/profiles/profile-2.png'); ?>" />
                            <div class="dropdown-notifications-item-content">
                                <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                <div class="dropdown-notifications-item-content-details">Thomas Wilcox · 58m</div>
                            </div>
                        </a>
                        <!-- Example Message 2-->
                        <a class="dropdown-item dropdown-notifications-item" href="#!">
                            <img class="dropdown-notifications-item-img" src="<?php echo base_url('assets/img/illustrations/profiles/profile-3.png'); ?>" />
                            <div class="dropdown-notifications-item-content">
                                <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                <div class="dropdown-notifications-item-content-details">Emily Fowler · 2d</div>
                            </div>
                        </a>
                        <!-- Example Message 3-->
                        <a class="dropdown-item dropdown-notifications-item" href="#!">
                            <img class="dropdown-notifications-item-img" src="<?php echo base_url('assets/img/illustrations/profiles/profile-4.png'); ?>" />
                            <div class="dropdown-notifications-item-content">
                                <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                <div class="dropdown-notifications-item-content-details">Marshall Rosencrantz · 3d</div>
                            </div>
                        </a>
                        <!-- Example Message 4-->
                        <a class="dropdown-item dropdown-notifications-item" href="#!">
                            <img class="dropdown-notifications-item-img" src="<?php echo base_url('assets/img/illustrations/profiles/profile-5.png'); ?>" />
                            <div class="dropdown-notifications-item-content">
                                <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                <div class="dropdown-notifications-item-content-details">Colby Newton · 3d</div>
                            </div>
                        </a>
                        <!-- Footer Link-->
                        <a class="dropdown-item dropdown-notifications-footer" href="#!">Read All Messages</a>
                    </div>
                </li>
                <!-- User Dropdown-->
                <li class="nav-item dropdown no-caret mr-3 mr-lg-0 dropdown-user">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="<?php echo base_url('assets/img/illustrations/profiles/profile-1.png'); ?>" /></a>
                    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            <img class="dropdown-user-img" src="<?php echo base_url('assets/img/illustrations/profiles/profile-1.png'); ?>" />
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name">
								<?php 
									if($this->session->userdata('firstname') == '') { 
										echo "Guest User";
									}else{
										echo $this->session->userdata('firstname'). " ".$this->session->userdata('lastname');
									}
								?>
								</div>
                                <div class="dropdown-user-details-email">
								<?php 
									if($this->session->userdata('email') == '') { 
										echo "xyz@gmail.com";
									}else{
										echo $this->session->userdata('email');
									}
								?>
								</div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url('/account'."/".$this->session->userdata('username')); ?>">
                            <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            Account
                        </a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sidenav shadow-right sidenav-light">
                    <div class="sidenav-menu">
                        <div class="nav accordion" id="accordionSidenav">
                            <!-- Sidenav Menu Heading (Account)-->
                            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                            <div class="sidenav-menu-heading d-sm-none">Account</div>
                            <!-- Sidenav Link (Alerts)-->
                            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                            <a class="nav-link d-sm-none" href="#!">
                                <div class="nav-link-icon"><i data-feather="bell"></i></div>
                                Alerts
                                <span class="badge badge-warning-soft text-warning ml-auto">4 New!</span>
                            </a>
                            <!-- Sidenav Link (Messages)-->
                            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                            <a class="nav-link d-sm-none" href="#!">
                                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                                Messages
                                <span class="badge badge-success-soft text-success ml-auto">2 New!</span>
                            </a>
							<a class="nav-link" href="<?php echo base_url();  ?>">
                                <div class="nav-link-icon"><i data-feather="home"></i></div>
                                Dashboard
                            </a>
                            <!-- Sidenav Menu Heading (Core)-->
                            <div class="sidenav-menu-heading">Invoice</div>

                            <?php if(!(access_lavel(3, $this->session->userdata('role') ))){ ?>

                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardsinvoice" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="file-minus"></i></div>
                                Sell
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardsinvoice" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/invoicedetail'); ?>">Sell Invoice List</a>
                                    <a class="nav-link" href="<?php echo base_url('/createinvoice'); ?>">New Sell Invoice</a>
                                </nav>
                            </div>

							<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardspurchase" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="file-plus"></i></div>
                                Purchase
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardspurchase" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/invoicepurchasedetail'); ?>">Purchase Invoice List</a>
                                    <a class="nav-link" href="<?php echo base_url('/createpurchaseinvoice'); ?>">New Purchase Invoice</a>
                                </nav>
                            </div>
							<?php } ?>
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseOrders" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="file-plus"></i></div>
                                Order
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseOrders" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/orders'); ?>">Order List</a>
                                    <a class="nav-link" href="<?php echo base_url('/createorder'); ?>">New Order</a>
                                </nav>
                            </div>
                            
                            <?php if(!(access_lavel(3, $this->session->userdata('role') ))){ ?>
                            <div class="sidenav-menu-heading">Utility</div>

                            <!-- Sidenav Accordion (Items)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardsStock" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="database"></i></div>
                                Stock
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardsStock" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/getstock'); ?>">Stock List</a>
                                    <a class="nav-link" href="<?php echo base_url('/getstocklog'); ?>">Stock log</a>
                                </nav>
                            </div>

                            <!-- Account(Items)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardsAccount" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="database"></i></div>
                                Account
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardsAccount" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/getaccount'); ?>">Account List</a>
                                    <a class="nav-link" href="<?php echo base_url('/getaccounthistory'); ?>">Account History</a>
                                </nav>
                            </div>
                            
                            <!-- Sidenav Accordion (Clients)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardsClient" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="user-plus"></i></div>
                                Clients
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardsClient" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/clientdetails'); ?>">Clients List</a>
                                    <a class="nav-link" href="<?php echo base_url('/createclient'); ?>">New Client</a>
                                </nav>
                            </div>

                            <!-- Sidenav Accordion (Items)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardsItem" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="figma"></i></div>
                                Product
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardsItem" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/itemdetails'); ?>">Product List</a>
                                    <a class="nav-link" href="<?php echo base_url('/createitem'); ?>">New Product</a>
                                    <?php if($this->session->userdata('feature_group_for_item')){ ?>
                                    <a class="nav-link" href="<?php echo base_url('/productgroupdetails'); ?>">Product Group List</a>
                                    <?php } ?>
                                </nav>
                            </div>
							<!-- Sidenav Accordion (Clients)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardstags" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="life-buoy"></i></div>
                                Tags/Box
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardstags" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/tagdetails'); ?>">Tags List</a>
                                    <a class="nav-link" href="<?php echo base_url('/createtag'); ?>">New Tag</a>
                                </nav>
                            </div>
                            <!-- Sidenav Accordion (Clients)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardscompany" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="life-buoy"></i></div>
                                Companies
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardscompany" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/companydetails'); ?>">Companies List</a>
                                    <a class="nav-link" href="<?php echo base_url('/createcompany'); ?>">New Company</a>
                                </nav>
                            </div>

                            <!-- Sidenav Accordion (Users)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardsReport" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="file"></i></div>
                                Reports
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardsReport" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/stock'); ?>">Stock</a>
                                    <a class="nav-link" href="<?php echo base_url('/ledger'); ?>">Ledger</a>
                                    <a class="nav-link" href="<?php echo base_url('/partyledger'); ?>">Party Ledger</a>
                                    <a class="nav-link" href="<?php echo base_url('/allzonesale'); ?>">All Zone Sale</a>
                                    <a class="nav-link" href="<?php echo base_url('/sales'); ?>">Sales</a>
                                    <a class="nav-link" href="<?php echo base_url('/invoice'); ?>">Invoice</a>
                                </nav>
                            </div>

                            <?php } ?>
							
                            <div class="sidenav-menu-heading">Account</div>
                            <?php if(!(access_lavel(3, $this->session->userdata('role') ))){ ?>
							<!-- Sidenav Accordion (Users)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardsUser" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="users"></i></div>
                                Users
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardsUser" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/userdetails'); ?>">Users List</a>
                                    <a class="nav-link" href="<?php echo base_url('/createuser'); ?>">New user</a>
                                </nav>
                            </div>
							<?php } ?>
                            <!-- Sidenav Accordion (Users)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardsProfile" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="settings"></i></div>
                                Setting
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardsProfile" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/account'."/".$this->session->userdata('username')); ?>">Account</a>
                                    <a class="nav-link" href="<?php echo base_url('/changepassword'); ?>">Change Password</a>
                                    <a class="nav-link" href="<?php echo base_url('/termconditions'); ?>">Term & Conditions</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardsPiggy" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                                Expenses
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardsPiggy" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/accountholderbalance') ?>">Account Holder Balance</a>
                                    <a class="nav-link" href="<?php echo base_url('/accountholderlist'); ?>">Account Holder List</a>
                                    <a class="nav-link" href="<?php echo base_url('/newaccountholder'); ?>">New Account Holder</a>
                                </nav>
                            </div>

                            <?php if(!(access_lavel(5, $this->session->userdata('role') ))){ ?>
							<!-- Sidenav Accordion (Users)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboardsFirm" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                                Firms
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboardsFirm" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo base_url('/firmdetails'); ?>">Firm List</a>
                                    <a class="nav-link" href="<?php echo base_url('/createfirm'); ?>">New Firm</a>
                                </nav>
                            </div>
							<?php } ?>
                            
                            <div> <!--Doubt div--->
                            </div>
                        </div>
                    </div>
                    <!-- Sidenav Footer-->
                    <div class="sidenav-footer">
                        <div class="sidenav-footer-content">
                            <div class="sidenav-footer-subtitle">Logged in as:</div>
                            <div class="sidenav-footer-title">
                                <?php 
                                if($this->session->userdata('firstname') == '') { 
                                    echo "Default User";
                                }else{
                                    echo $this->session->userdata('firstname'). " ".$this->session->userdata('lastname');
                                }
								?>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <!-- Main page content-->
                    <div class="container mt-5">
                        <!-- Custom page header alternative example-->
                        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-1">
                            <div class="mr-4 mb-3 mb-sm-0">
                                <h5 class="mb-0"><?php echo $title; ?></h5>
                                <div class="small">
                                    <span class="font-weight-500 text-warning"><?php 
                                    date_default_timezone_set('Asia/Kolkata'); 
                                    echo date("l"); ?></span>
                                    &middot; <?php echo date("F d, Y"); ?> &middot; <?php echo date("h:i:s A"); ?>
                                </div>
                            </div>
                            <div class="mr-4 mb-3 mb-sm-0">

                            </div>
                            <div class="mr-2 mb-3 mb-sm-0">
                                <?php if (isset($globalsearch)) {?>
                                <div class="input-group customSearchborder">
                                    <input class="form-control border-end-0 border rounded-pill" type="text" value="<?php echo isset($globalsearchtext) ? $globalsearchtext : ''; ?>" id="globalsearch">
                                    <span class="input-group-append">
                                        <button class="btn btn-outline-secondary bg-white border-start-0 border rounded-pill ms-n3" type="button" id="globalsearchbutton">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                    <span class="input-group-append">
                                        <button class="btn btn-outline-secondary bg-white border-start-0 border rounded-pill ms-n3" type="button" id="globalclearhbutton">
                                            <i class="fa fa-times-circle"></i>
                                        </button>
                                    </span>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="mr-2 mb-3 mb-sm-0">
                                <?php if (isset($buttonName)) {?>
                                <a class="nav-link btn btn-warning" role="button" href="<?php echo $buttonLink; ?>"><?php echo $buttonName; ?></a>
                                <?php } ?>
                            </div>
                        </div>
							<?php echo $contents;?>
                    </div>
                </main>
				<!--------->
				<!-- Logout Modal-->
				<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
					aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
								<button class="close" type="button" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
							<div class="modal-footer">
								<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
								<a class="btn btn-warning" href="<?php echo base_url('/logout')?>">Logout</a>
							</div>
						</div>
					</div>
				</div>
				<!---------->

            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url();?>assets/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url();?>assets/demo/chart-area-demo.js"></script>
        <script src="<?php echo base_url();?>assets/demo/chart-bar-demo.js"></script>
        <script src="<?php echo base_url();?>assets/demo/chart-pie-demo.js"></script>
        <script src="<?php echo base_url();?>assets/demo/chart-sell-bar.js"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('assets/demo/date-range-picker-demo.js'); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
        <script src="https://cdn.rawgit.com/meetselva/attrchange/master/js/attrchange.js"></script>
        <script src="https://cdn.rawgit.com/meetselva/attrchange/master/js/attrchange_ext.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

        <!-- (Optional) Latest compiled and minified JavaScript translation files -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/i18n/defaults-*.min.js"></script> -->
        <script>
            $(".uppercase").keyup(function(){
                this.value = this.value.toLocaleUpperCase();
            });

            function dateFormateConvert(date){
                var d=new Date(date.split("/").reverse().join("-"));
                var dd=d.getDate();
                var mm=d.getMonth()+1;
                var yy=d.getFullYear();
                return mm+"/"+dd+"/"+yy;
            }
        </script>
    </body>
</html>
