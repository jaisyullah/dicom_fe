<?php
	$str_apl = 'index';
	if(is_file("_lib/_app_data/" . $str_apl . '_ini.php'))
	{
		require("_lib/_app_data/" . $str_apl . '_ini.php');
		$str_apl = $arr_data['friendly_url'];
	}
	else
	{
		$str_apl = $str_apl . '/';
	}
    header("Location: " . $str_apl);

?>