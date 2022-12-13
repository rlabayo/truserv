<?php

/**
 * File             : View Header
 * @author          : Rhea Labayo
 * @copyright       : 2016 December
 * Date Updated     : December 1, 2016
 *
 */

if (isset($this->session->userdata['is_logged_in'])) {
    $username = ($this->session->userdata['username']);
    $email = ($this->session->userdata['email']);
    $firstName = ($this->session->userdata['firstName']);
    $lastName = ($this->session->userdata['lastName']);
} 

if( $data['korean']['notificationCount'] == '' ){
    $data['korean']['notificationCount'] = 0;
}

?>
<html>
<head>
    <title>TRUSERV</title>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/bootstrap-theme.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/bootstrap-theme.min.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font_awesome/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font_awesome/css/font-awesome.min.css" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logo.png" />
<?php 
    if( $data['korean']['notificationCount'] == '' ){
        $data['korean']['notificationCount'] = 0;
    }
?>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-expand-lg navbar-light bg-light"> 
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
              </button>
              <a class="navbar-brand" href="#">TRUSERV</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav">
                <li class="nav-item"><a href="<?php echo base_url(); ?>" role="button" >Home</a></li>
                    <li class="dropdown nav-item">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Korean<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url(); ?>korean/view">Record</a></li>
                            <li><a href="<?php echo base_url(); ?>korean/notification">Notification <span><b><?php echo $data['korean']['notificationCount']; ?></b></span></a></li>
                        </ul>
                    </li>
                    <li class="dropdown nav-item">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Other Citizenship<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url(); ?>other/view">Record</a></li>
                            <li><a href="<?php echo base_url(); ?>other/notification">Notification <span><b><?php echo $data['other']['notificationCount']; ?></b></span></a></li>
                        </ul>
                    </li>
                    <li class="dropdown nav-item">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url(); ?>report/viewKoreanReports">Korean</a></li>
                            <li><a href="<?php echo base_url(); ?>report/viewOtherReports">Other</a></li>
                        </ul>
                    </li>
                    <li class="dropdown nav-item">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Utilities<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url(); ?>utilities/viewFolderName">Folder Name</a></li>
                            <li><a href="<?php echo base_url(); ?>utilities/viewVisaStatus">Visa Status</a></li>
                            <li><a href="<?php echo base_url(); ?>utilities/viewPetitioner">Petitioner</a></li>
                        </ul>
                    </li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"> </span><?php echo '  '. $firstName.' '.$lastName; ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>settings/<?php echo $username; ?>">User Settings</a></li>
                    <?php if( $username == 'admin' ){?>
                        <li><a href="<?php echo base_url(); ?>add_user">Another User?</a></li>
                    <?php } ?>
                    </ul>
                </li>
                <li><a href="<?php echo base_url(); ?>logout"><span class="glyphicon glyphicon-log-in"></span> <?php echo '  ';?> Logout</a></li>
            </ul>
            </div>
          </div>
       </nav>
    </div>
    
       