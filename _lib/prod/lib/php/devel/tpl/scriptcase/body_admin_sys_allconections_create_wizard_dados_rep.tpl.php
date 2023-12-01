<?php

nm_load_class('interface', 'Connection');
$obj_conn = new nmConnection();

//Carrega Array com Grupos do ScriptCase
$conHas                = $this->GetVar('conHas');
$btn_avanc             = $this->GetVar('btn_avanc');
$btn_retor             = $this->GetVar('btn_retor');
$server                = $this->GetVar('server');
$base                  = $this->GetVar('base');
$oracle_type           = $this->GetVar('oracle_type');
$schema                = $this->GetVar('schema');
$rep                   = $this->GetVar('rep');
$repositorios          = $this->GetVar('repositorios');
$postgres_encoding     = $this->GetVar('postgres_encoding');
$oracle_encoding       = $this->GetVar('oracle_encoding');
$mysql_encoding        = $this->GetVar('mysql_encoding');
$db2_autocommit        = $this->GetVar('db2_autocommit');
$db2_i5_lib            = $this->GetVar('db2_i5_lib');
$db2_i5_naming         = $this->GetVar('db2_i5_naming');
$db2_i5_commit         = $this->GetVar('db2_i5_commit');
$db2_i5_query_optimize = $this->GetVar('db2_i5_query_optimize');

$pg_client_encoding   = array();
if(is_file($nm_config['path_prod'] . "sql/charset/postgres.php"))
{
    $arr_charset_db = array();
    include($nm_config['path_prod'] . "sql/charset/postgres.php");
    $pg_client_encoding = $arr_charset_db;
}

$oracle_client_encoding = array();
if(is_file($nm_config['path_prod'] . "sql/charset/oracle.php"))
{
    $arr_charset_db = array();
    include($nm_config['path_prod'] . "sql/charset/oracle.php");
    $oracle_client_encoding = $arr_charset_db;
}

$mysql_client_encoding = array();
if(is_file($nm_config['path_prod'] . "sql/charset/mysql.php"))
{
    $arr_charset_db = array();
    include($nm_config['path_prod'] . "sql/charset/mysql.php");
    $mysql_client_encoding = $arr_charset_db;
}

$dbms = $this->GetVar('dbms');
$conn = $this->GetVar('conn');
 
if ($conn == "")
{
	$conn = "connect";
}
?>

<script language="javascript" src="<?php echo $nm_config['url_js_third']; ?>wz_tooltip/wz_tooltip.js"></script>

<form action="<?php echo nm_url_rand($nm_config['url_iface'] . 'admin_sys_allconections_create_wizard.php'); ?>" name="form_create" METHOD="post">
<center>

<?php

$td_width_1 = "265px";
$td_width_2 = "225px";
$td_width_3 = "50px";

if (isset($_POST['ajax']) && $_POST['ajax'] == "S")
{
	echo "__#$@$#__";
}
else 
{
?>
<table class="nmTable">
   <tr>
      <td class="nmTitle" align="center" colspan="3"><?php echo $nm_lang['page_title']; ?></td>
   </tr>		
<?php
}

if (!(isset($_POST['ajax']) && $_POST['ajax'] == "S"))
{
?>
	   
    
   <tr style="display:<?php echo (in_array($dbms, array('firebird', 'odbc', 'progress', 'sybase')) ? "" : "none"); ?>">
      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;&nbsp;&nbsp;<?php echo $nm_lang['label']['conn']; ?>&nbsp;</td>
      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
      	<INPUT name='conn' value='<?php echo $conn; ?>' type="text" class="nmInput">
      </td>
      <td class="nmLineV3" width="<?php echo $td_width_3; ?>" align="left" valign="middle">          
      </td>
   </tr>   
   <?PHP
}   
       if($conHas['server']=='S')
       {
       		$default = $port = "";
       		$hasPort = false;
       		
       		$arr_db_ports = array();
			$arr_db_ports['mysql']    = "3306";
			$arr_db_ports['postgres'] = "5432";
			$arr_db_ports['db2']      = "50000";
			$arr_db_ports['mssql']    = "1433";
			$arr_db_ports['sybase']   = "5000";
			$arr_db_ports['firebird'] = "3050";
			$arr_db_ports['ibase']    = "3050";
			if (isset($arr_db_ports[ $obj_conn->nm_db_sc_type($dbms) ]))
			{
				$hasPort = true;
			    $port = $arr_db_ports[ $obj_conn->nm_db_sc_type($dbms) ];
			    
				if (strrpos($server, ":") !== false)
				{
					$server1 = substr($server, 0, strrpos($server, ":"));
					$server2 = substr($server, strrpos($server, ":") + 1);

					if (is_numeric($server2))
					{
						$server = $server1;
						$port   = $server2;
					}
				}
			}
       	
   ?>
   <tr>
      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;&nbsp;&nbsp;<?php echo $nm_lang['label']['server']; ?>&nbsp;</td>
      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
          <input type='text' name='server' id='server' value='<?php echo $server; ?>' class="nmInput" onchange="$('#carregar_db').val('S');">
      </td>
      <td class="nmLineV3"  width="<?php echo $td_width_3; ?>" align="left" valign="middle"> 
      </td>
   </tr>

   <tr style="display:<?php echo ($hasPort ? '' : 'none'); ?>">
      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;&nbsp;&nbsp;<?php echo sprintf($nm_lang['label']['port'], $default); ?>&nbsp;</td>
      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
      		<table cellpadding="0" cellspacing="0">
      			<tr>
      				<td>
          				<input type='text' name='port' id='port' size="5" onblur="if ($('#port').val() == '') {$('#port').val('0');}" value='<?php echo $port; ?>' class="nmInput" maxlength="6" style="text-align: right; height:19px" onchange="$('#carregar_db').val('S');" />
          			</td>
          			<td>
          				<table cellpadding="0" cellspacing="0" width="18px" align="center">	
          					<tr><td style="cursor:pointer; border-top:1px solid #7f9db9; border-right:1px solid #7f9db9"><img src="<?php echo $nm_config['url_img']; ?>seta_cima.png"  onclick="$('#port').val(parseInt($('#port').val()) + 1); $('#carregar_db').val('S');" /></td></tr>
          					<tr><td style="cursor:pointer; border-top:1px solid #7f9db9; border-right:1px solid #7f9db9; border-bottom:1px solid #7f9db9"><img src="<?php echo $nm_config['url_img']; ?>seta_baixo.png" onclick="if (parseInt($('#port').val()) > 0) {$('#port').val(parseInt($('#port').val()) - 1); $('#carregar_db').val('S');}" /></td></tr>
          				</table>
          			</td>
          		</tr>
          	</table>
      </td>   
      <td class="nmLineV3"  width="<?php echo $td_width_3; ?>" align="left" valign="middle"> 
      </td>
   </tr>

   <?php
       }
       if($conHas['base']=='S')
       {
       	
       		if ($obj_conn->nm_db_sc_type($dbms) == 'mysql')
       		{
       			?>
       			<tr style="display:none"><td colspan="3"><input type="hidden" name="base" id="base" value='<?php echo $base; ?>' /></td></tr>
       			<?php
       		}
       		else 
       		{
   ?>   
   <tr>
      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;&nbsp;&nbsp;<?php echo $nm_lang['label']['base']; ?>&nbsp;</td>
      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
          <input type='text' name='base' value='<?php echo $base; ?>' class="nmInput">
      </td>
      <td class="nmLineV3"  width="<?php echo $td_width_3; ?>" align="left" valign="middle"></td>      
   </tr>
   <?php
       		}
       }

       if($conHas['oracle_type']=='S')
       {
   ?>
   <tr style="display:none">
      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;</td>
      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
          <input type="radio" id="oracle_type_service_name" name="oracle_type" value="service_name" <?php echo ($oracle_type=='service_name')?'checked=checked':''; ?> style="vertical-align: middle" />
          <label for="oracle_type_service_name">Service Name</label>
          &nbsp;&nbsp;
          <input type="radio" id="oracle_type_sid" name="oracle_type" value="sid" <?php echo ($oracle_type=='sid')?'checked=checked':''; ?> style="vertical-align: middle" />
          <label for="oracle_type_sid">SID</label><br>
      </td>
      <td class="nmLineV3"  width="<?php echo $td_width_3; ?>" align="left" valign="middle"></td>
   </tr>
   <?php
       }

       if($conHas['schema']=='S')
       {
   ?>   
   <tr>
      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;&nbsp;&nbsp;<?php echo $nm_lang['label']['schema']; ?>&nbsp;</td>
      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
          <input type='text' name='schema' value='<?php echo $schema?>' class="nmInput" >
      </td>
      <td class="nmLineV3"  width="<?php echo $td_width_3; ?>" align="left" valign="middle"></td>      
   </tr>
   <?php
       }
       
	   if (isset($_POST['ajax']) && $_POST['ajax'] == "S")
	   {
			echo "__#$@$#__";
	   }

	   if ($obj_conn->nm_db_sc_type($dbms) == "oracle")
	   {
	?>	   
	   
	   <tr style="display:">
	      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;&nbsp;&nbsp;client_encoding</td>
	      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
	          <select name="oracle_encoding" class="nmInput">
	          	<option value="" <?php if(empty($oracle_encoding)){ echo "selected"; } ?>></option>
	          	<?php
	          	foreach ($oracle_client_encoding as $key=>$value)
	          	{
	          		if (strlen($value) > 50)
	          		{
	          			$value = substr($value, 0, 47) . "...";
	          		}
	          		
	          		?>
	          		<option value="<?php echo $key; ?>" <?php if($oracle_encoding==$key){ echo "selected"; } ?>><?php echo $key . " - " . $value; ?></option>
	          		<?php
	          	}
	          	?>
	          </select>
	      </td>
	      <td class="nmLineV3" width="<?php echo $td_width_3; ?>" align="left" valign="middle">&nbsp;</td>
	   </tr>	   
	   
	   
	<?php  
	   }
	   elseif ($obj_conn->nm_db_sc_type($dbms) == "postgres")
	   {
   	?>
	   <tr style="display:">
	      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;&nbsp;&nbsp;client_encoding</td>
	      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
	          <select name="postgres_encoding" class="nmInput">
	          	<option value="" <?php if(empty($postgres_encoding)){ echo "selected"; } ?>></option>
	          	<?php
	          	foreach ($pg_client_encoding as $key=>$value)
	          	{
	          		?>
	          		<option value="<?php echo $key; ?>" <?php if($postgres_encoding==$key){ echo "selected"; } ?>><?php echo $key; ?> - <?php echo $value; ?></option>
	          		<?php
	          	}
	          	?>
	          </select>
	      </td>
	      <td class="nmLineV3" width="<?php echo $td_width_3; ?>" align="left" valign="middle">&nbsp;</td>
	   </tr>   	
   	<?php
	   }elseif ($obj_conn->nm_db_sc_type($dbms) == "mysql")
	   {
   	?>
	   <tr style="display:">
	      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;&nbsp;&nbsp;client_encoding</td>
	      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
	          <select name="mysql_encoding" class="nmInput">
	          	<option value="" <?php if(empty($mysql_encoding)){ echo "selected"; } ?>></option>
	          	<?php
	          	foreach ($mysql_client_encoding as $key=>$value)
	          	{
	          		?>
	          		<option value="<?php echo $key; ?>" <?php if($mysql_encoding==$key){ echo "selected"; } ?>><?php echo $key; ?> - <?php echo $value; ?></option>
	          		<?php
	          	}
	          	?>
	          </select>
	      </td>
	      <td class="nmLineV3" width="<?php echo $td_width_3; ?>" align="left" valign="middle">&nbsp;</td>
	   </tr>   	
   	<?php
	   }	   
	   
	    
       if($conHas['db2']=='S')
       {
       	
       		if (!(isset($_POST['ajax']) && $_POST['ajax'] == "S"))
	   		{				
   ?>
   <tr>
      <td class="nmLineV3" colspan="3">&nbsp;</td>
   </tr>
   <?php
	   		}
   ?>
   <tr>
      <td class="nmLineV3" colspan="3" align="center" style="border:1px dotted #ff0000;"><?php echo $nm_lang['form_db2_warning']; ?></td>
   </tr>
   <!--tbody style="display:<?php if(DB2_AUTOCOMMIT_ON=="" && DB2_AUTOCOMMIT_OFF==""){ echo "none"; } ?>"-->
	   <tr style="display:<?php if(DB2_AUTOCOMMIT_ON=="" && DB2_AUTOCOMMIT_OFF==""){ echo "none"; } ?>">
	      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;&nbsp;&nbsp;autocommit</td>
	      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
	          <select name="db2_autocommit" class="nmInput">
	            <option value="" <?php if(empty($db2_autocommit)){ echo "selected"; } ?>></option>
	            <option value="<?php echo DB2_AUTOCOMMIT_ON; ?>" <?php if($db2_autocommit==DB2_AUTOCOMMIT_ON && DB2_AUTOCOMMIT_ON!=''){ echo "selected"; } ?>>DB2_AUTOCOMMIT_ON</option>
	            <option value="<?php echo DB2_AUTOCOMMIT_OFF; ?>" <?php if($db2_autocommit==DB2_AUTOCOMMIT_OFF && DB2_AUTOCOMMIT_OFF!=''){ echo "selected"; } ?>>DB2_AUTOCOMMIT_OFF</option>
	          </select>
	      </td>
	      <td class="nmLineV3" width="<?php echo $td_width_3; ?>" align="left" valign="middle">&nbsp;</td>
	   </tr>


   <!--/tbody-->
   <tr>
      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;&nbsp;&nbsp;i5_lib</td>
      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
          <input type='text' name='db2_i5_lib' value='<?php echo $db2_i5_lib; ?>' class="nmInput" >
      </td>
      <td class="nmLineV3" width="<?php echo $td_width_3; ?>" align="left" valign="middle">&nbsp;</td>
   </tr>
   <!--tbody style="display:<?php if(DB2_I5_NAMING_ON=="" && DB2_I5_NAMING_OFF==""){ echo "none"; } ?>"-->
	   <tr style="display:<?php if(DB2_I5_NAMING_ON=="" && DB2_I5_NAMING_OFF==""){ echo "none"; } ?>">
	      <td class="nmLineV3">i5_naming</td>
	      <td class="nmLineV3">
	          <select name="db2_i5_naming" class="nmInput">
	            <option value="" <?php if(empty($db2_i5_naming)){ echo "selected"; } ?>></option>
	            <option value="<?php echo DB2_I5_NAMING_ON; ?>" <?php if($db2_i5_naming==DB2_I5_NAMING_ON && DB2_I5_NAMING_ON!=''){ echo "selected"; } ?>>DB2_I5_NAMING_ON</option>
	            <option value="<?php echo DB2_I5_NAMING_OFF; ?>" <?php if($db2_i5_naming==DB2_I5_NAMING_OFF && DB2_I5_NAMING_OFF!=''){ echo "selected"; } ?>>DB2_I5_NAMING_OFF</option>
	          </select>
	      </td>
	      <td class="nmLineV3" align="center" valign="middle">&nbsp;</td>
	   </tr>
   <!--/tbody-->
   <!--tbody style="display:<?php if(DB2_I5_TXN_NO_COMMIT=="" && DB2_I5_TXN_READ_UNCOMMITTED=="" && DB2_I5_TXN_READ_COMMITTED=="" && DB2_I5_TXN_REPEATABLE_READ=="" && DB2_I5_TXN_SERIALIZABLE==""){ echo "none"; } ?>"-->
	   <tr style="display:<?php if(DB2_I5_TXN_NO_COMMIT=="" && DB2_I5_TXN_READ_UNCOMMITTED=="" && DB2_I5_TXN_READ_COMMITTED=="" && DB2_I5_TXN_REPEATABLE_READ=="" && DB2_I5_TXN_SERIALIZABLE==""){ echo "none"; } ?>">
	      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;&nbsp;&nbsp;i5_commit</td>
	      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
	          <select name="db2_i5_commit" class="nmInput">
	            <option value="" <?php if(empty($db2_i5_commit)){ echo "selected"; } ?>></option>
		        <option value="<?php echo DB2_I5_TXN_NO_COMMIT; ?>" <?php if($db2_i5_commit==DB2_I5_TXN_NO_COMMIT && DB2_I5_TXN_NO_COMMIT!=''){ echo "selected"; } ?>>DB2_I5_TXN_NO_COMMIT</option>
	            <option value="<?php echo DB2_I5_TXN_READ_UNCOMMITTED; ?>" <?php if($db2_i5_commit==DB2_I5_TXN_READ_UNCOMMITTED && DB2_I5_TXN_READ_UNCOMMITTED!=''){ echo "selected"; } ?>>DB2_I5_TXN_READ_UNCOMMITTED</option>
	            <option value="<?php echo DB2_I5_TXN_READ_COMMITTED; ?>" <?php if($db2_i5_commit==DB2_I5_TXN_READ_COMMITTED && DB2_I5_TXN_READ_COMMITTED!=''){ echo "selected"; } ?>>DB2_I5_TXN_READ_COMMITTED</option>
	            <option value="<?php echo DB2_I5_TXN_REPEATABLE_READ; ?>" <?php if($db2_i5_commit==DB2_I5_TXN_REPEATABLE_READ && DB2_I5_TXN_REPEATABLE_READ!=''){ echo "selected"; } ?>>DB2_I5_TXN_REPEATABLE_READ</option>
	            <option value="<?php echo DB2_I5_TXN_SERIALIZABLE; ?>" <?php if($db2_i5_commit==DB2_I5_TXN_SERIALIZABLE && DB2_I5_TXN_SERIALIZABLE!=''){ echo "selected"; } ?>>DB2_I5_TXN_SERIALIZABLE</option>
	          </select>
	      </td>
	      <td class="nmLineV3" width="<?php echo $td_width_3; ?>" align="left" valign="middle">&nbsp;</td>
	   </tr>
   <!--/tbody-->
   <!--tbody style="display:<?php if(DB2_FIRST_IO=="" && DB2_ALL_IO==""){ echo "none"; } ?>"-->
	   <tr style="display:<?php if(DB2_FIRST_IO=="" && DB2_ALL_IO==""){ echo "none"; } ?>">
	      <td class="nmLineV3" width="<?php echo $td_width_1; ?>">&nbsp;&nbsp;&nbsp;i5_query_optimize</td>
	      <td class="nmLineV3" width="<?php echo $td_width_2; ?>">
	          <select name="db2_i5_query_optimize" class="nmInput">
	            <option value="" <?php if(empty($db2_i5_query_optimize)){ echo "selected"; } ?>></option>
	            <option value="<?php echo DB2_FIRST_IO; ?>" <?php if($db2_i5_query_optimize==DB2_FIRST_IO && DB2_FIRST_IO!=''){ echo "selected"; } ?>>DB2_FIRST_IO</option>
	            <option value="<?php echo DB2_ALL_IO; ?>" <?php if($db2_i5_query_optimize==DB2_ALL_IO && DB2_ALL_IO!=''){ echo "selected"; } ?>>DB2_ALL_IO</option>
	          </select>
	      </td>
	      <td class="nmLineV3"  width="<?php echo $td_width_3; ?>" align="left" valign="middle">&nbsp;</td>
	   </tr>
   <!--/tbody-->
   <?php
       }
       
	if (isset($_POST['ajax']) && $_POST['ajax'] == "S")
	{
		echo "__#$@$#__";
	}       
?>   
   
</table>

<?php
//aaaa
?>
<input type="hidden" name="rep" value="<?PHP echo $rep; ?>">
<?php
//fim aaaa
?>
<br>
<input type="hidden" name="form_create" value="<?php echo $nm_config['form_valid']; ?>" />

<input type='button' name='voltar' value='<?php echo $nm_lang['create_conn_wizard']['btnvoltar']; ?>' onclick="setStep('<?php echo $btn_retor; ?>');" class="nmButton">
<input type='button' name='avancar' value='<?php echo $nm_lang['create_conn_wizard']['btnavancar']; ?>' onclick="setStep('<?php echo $btn_avanc; ?>');" class="nmButton">
<input type='button' name='sair' value='<?php echo $nm_lang['create_conn_wizard']['btnsair']; ?>' onclick="setStep('cancel');" class="nmButton">
<input type='hidden' value='<?php echo $this->GetVar('step');?>' name='step'>
<input type='hidden' value='' name='nextstep'>
</center>


<BR \>
<BR \>
<DIV style="display:none" id="id_server">
<TABLE WIDTH="400" align='center' class="nmTitle">
  <TR>
    <TD width="100" class="nmLineV3" valign="top">
        <?php echo $nm_lang['label']['server']; ?>
    </TD>
    <TD width='300' class="nmLineV3">
    	<?php echo $nm_lang['create_conn_wizard']['descricoes']['server']; ?>
    </TD>
  </TR>
</TABLE>
</DIV>
<DIV style="display:none" id="id_base">
<TABLE WIDTH="400" align='center' class="nmTitle">
  <TR>
    <TD width="100" class="nmLineV3" valign="top">
        <?php echo $nm_lang['label']['base']; ?>
    </TD>
    <TD width='300' class="nmLineV3">
    	<?php echo $nm_lang['create_conn_wizard']['descricoes']['base']; ?>
    </TD>
  </TR>
</TABLE>
</DIV>
<DIV style="display:none" id="id_schema">
<TABLE WIDTH="400" align='center' class="nmTitle">
  <TR>
    <TD width="100" class="nmLineV3" valign="top">
        <?php echo $nm_lang['label']['schema']; ?>
    </TD>
    <TD width='300' class="nmLineV3">
    	<?php echo $nm_lang['create_conn_wizard']['descricoes']['schema']; ?>
    </TD>
  </TR>
</TABLE>
</DIV>
</form>