<!--LOGIN VIEW BAR-->
<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>
	<!--TITLE-->
	<title><?php echo $title; ?></title>

	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	    <meta name="viewport" content="width=device-width, initial-scale=1" />
	    
	    <link rel="icon" href="<?php echo base_url(); ?>assets/favicon.ico"type="image/x-icon" />
	    <!-- END META SECTION -->
	    
	    <!-- CSS INCLUDE -->        
	    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>assets/css/theme-default.css"/>
	    <!-- EOF CSS INCLUDE -->   
</head>
<body>
	<!--LOGIN CONTAINER-->
	<div class="login-container">
        <div class="login-box animated fadeInDown">
            <div class="login-logo"></div>
            <div class="login-body">
                <div class="login-title"><strong>Selamat Datang di TAM</strong>, Silahkan Login</div>

                <?php 
                //form open
                $attributes = array('class' => 'form-horizontal', 'id' => 'myform','role'=>'form');
                echo form_open($action,$attributes);?>
                
                <!--email pegawai field-->    
                <div class="form-group">
                    <div class="col-md-12">
                    	<input type="text" class="form-control" placeholder="Email Pegawai" name="email_pegawai" id="email" value="<?php echo set_value('email_pegawai');?>">                        
                    </div>
                </div>
                <!-- end email pegawai field -->
                
                <!-- password field -->
                <div class="form-group">
                    <div class="col-md-12">
                    	<input type="password" class="form-control" placeholder="Password" name="password"  id="password" value="<?php echo set_value('password');?>">
                        <?= $error != ''?"<div class='error-on-login'>$error</div>":""?>
                    </div>
                </div>
                <!-- end password field -->

                <!--submit button-->
                <div class="form-group">
                    <div class="col-md-12">
                    	<?php echo form_submit('submit','Login',"class='btn btn-info btn-block'"); ?>
                    </div>
                </div>
                <!-- end submit button -->

                <?php
                //form close 
                echo form_close();?>

            </div>
            <div class="login-footer">
                <div class="pull-left">
                    <span style="color:#CE271E;">&copy; 2015 Telkom Akses Monitoring </span>
                </div>
            </div>
        </div>   
    </div>
	<!--END LOGIN CONTAINER-->

    <!-- START PLUGINS -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap.min.js"></script>        
    <!-- END PLUGINS -->

    <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/plugins/jquery-validation/jquery.validate.js'></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/fileinput/fileinput.min.js"></script>
    <script type="text/javascript">
        var myform = $("#myform").validate({
            ignore: [],
            rules: {                                            
                    email_pegawai: {
                        required: true,
                        email: true
                    },
                    password:{
                        required:true
                    }

                }                                        
        });

        if($('#password').val() != ''){
            $('.error-on-login').show();
        }
        $('#password').change(function(){
            if($('#password').val() == ''){
                $('.error-on-login').css('display','none');
            }
        });
    </script>     
</body>
</html>