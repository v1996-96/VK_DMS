

<link href="<?php echo $BASE; ?>/ui/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $BASE; ?>/ui/font-awesome/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<link href="<?php echo $BASE; ?>/ui/css/animate.css" rel="stylesheet">
<link href="<?php echo $BASE; ?>/ui/css/style.css" rel="stylesheet">
<link href="<?php echo $BASE; ?>/ui/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo $BASE; ?>/ui/css/plugins/toastr/toastr.min.css" rel="stylesheet">

<style type="text/css">
#toast-container > .toast {
    background-image: none !important;
}

#toast-container > .toast:before {
    position: fixed;
    font-family: FontAwesome;
    font-size: 24px;
    line-height: 18px;
    float: left;
    color: #FFF;
    padding-right: 0.5em;
    margin: auto 0.5em auto -1.5em;
}        
#toast-container > .toast-warning:before {
    content: "\f003";
}
#toast-container > .toast-error:before {
    content: "\f071";
}
#toast-container > .toast-info:before {
    content: "\f005";
}
#toast-container > .toast-success:before {
    content: "\f002";
}
</style>