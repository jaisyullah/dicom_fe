<?php
 @session_start();
$_SESSION['scriptcase']['grid_examination']['glo_nm_path_imag_temp']  = "";
//check tmp
if(empty($_SESSION['scriptcase']['grid_examination']['glo_nm_path_imag_temp']))
{
    $str_path_apl_url = $_SERVER['PHP_SELF'];
    $str_path_apl_url = str_replace("\\", '/', $str_path_apl_url);
    $str_path_apl_url = substr($str_path_apl_url, 0, strrpos($str_path_apl_url, "/"));
    $str_path_apl_url = substr($str_path_apl_url, 0, strrpos($str_path_apl_url, "/")+1);
    /*check tmp*/$_SESSION['scriptcase']['grid_examination']['glo_nm_path_imag_temp'] = $str_path_apl_url . "_lib/tmp";
}
if (!isset($_SESSION['sc_session']))
{
    $NM_dir_atual = getcwd();
    if (empty($NM_dir_atual))
    {
        $str_path_sys  = (isset($_SERVER['SCRIPT_FILENAME'])) ? $_SERVER['SCRIPT_FILENAME'] : $_SERVER['ORIG_PATH_TRANSLATED'];
        $str_path_sys  = str_replace("\\", '/', $str_path_sys);
    }
    else
    {
        $sc_nm_arquivo = explode("/", $_SERVER['PHP_SELF']);
        $str_path_sys  = str_replace("\\", "/", getcwd()) . "/" . $sc_nm_arquivo[count($sc_nm_arquivo)-1];
    }
    $str_path_web    = $_SERVER['PHP_SELF'];
    $str_path_web    = str_replace("\\", '/', $str_path_web);
    $str_path_web    = str_replace('//', '/', $str_path_web);
    $root            = substr($str_path_sys, 0, -1 * strlen($str_path_web));
    if (is_file($root . $_SESSION['scriptcase']['grid_examination']['glo_nm_path_imag_temp'] . "/sc_apl_default_dicom_fe.txt"))
    {
?>
<html>
 <body>
  <form name="F0" method="post" action="./" target="_self" style="display: none"> 
  </form>
  <script language="javascript">
    document.F0.submit();
  </script>
 </body>
</html>
<?php
        exit;
    }
}
 $script_case_init = filter_input(INPUT_POST, 'script_case_init', FILTER_SANITIZE_NUMBER_INT);
 $path_botoes      = (isset($_POST['path_botoes'])) ? strip_tags($_POST['path_botoes']) : "";
 $apl_dependente   = (isset($_POST['apl_dependente'])) ? strip_tags($_POST['apl_dependente']) : "";
 $apl_opcao        = (isset($_POST['opcao'])) ? strip_tags($_POST['opcao']) : "print";
 $SC_module_export = (isset($_POST['SC_module_export'])) ? strip_tags($_POST['SC_module_export']) : "n";
 $apl_tipo_print   = (isset($_POST['tp_print']))  ? strip_tags($_POST['tp_print'])  : "PC";
 $apl_cor_print    = (isset($_POST['cor_print'])) ? strip_tags($_POST['cor_print']) : "PB";
 $apl_saida        = (isset($_POST['apl_saida'])) ? strip_tags($_POST['apl_saida']) : "";
?>
<html<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
 <head>
  <title>grid_examination :: PRINT</title>
 <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
<?php
 if ($_SESSION['scriptcase']['proc_mobile'])
 {
?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<?php
 }
?>
  <META http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT">
  <META http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?>" GMT">
  <META http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
  <META http-equiv="Cache-Control" content="post-check=0, pre-check=0">
  <META http-equiv="Pragma" content="no-cache">
  <link rel="shortcut icon" href="../_lib/img/scriptcase__NM__ico__NM__favicon.ico">
 </head>
 <body>
  <form name="Fini" method="post" 
        action="./" 
        target="_self"> 
    <input type="hidden" name="nmgp_opcao" value="<?php echo $apl_opcao;?>"/> 
    <input type="hidden" name="nmgp_tipo_print" value="<?php echo $apl_tipo_print;?>"/> 
    <input type="hidden" name="nmgp_cor_print" value="<?php echo $apl_cor_print;?>"/> 
    <input type="hidden" name="nmgp_navegator_print" value=""/> 
    <input type="hidden" name="SC_module_export" value="<?php echo $SC_module_export;?>"/> 
    <input type="hidden" name="script_case_init" value="<?php echo $script_case_init ?>"/> 
  </form> 
 <script>
    document.Fini.nmgp_navegator_print.value = navigator.appName;
    document.Fini.submit();
 </script>
 </body>
</html>
