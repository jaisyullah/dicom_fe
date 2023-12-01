<?php

class nmConnection
{

    function __construct()
    {
    } // nmConnection


    function TestConn($arr_conn)
    {
    	global $nm_config, $nm_lang;

    	$bol_conn   = FALSE;
    	$str_db_err = '';

        $str_dbms                  = isset($arr_conn['dbms']) ? $arr_conn['dbms'] : "";
        $str_host                  = isset($arr_conn['host']) ? $arr_conn['host'] : "";
        $str_user                  = isset($arr_conn['user']) ? $arr_conn['user'] : "";
        $str_pass                  = isset($arr_conn['pass']) ? $arr_conn['pass'] : "";
        $str_base                  = isset($arr_conn['base']) ? $arr_conn['base'] : "";
        $postgres_encoding         = isset($arr_conn['postgres_encoding']) ? $arr_conn['postgres_encoding'] : "";
        $oracle_encoding           = isset($arr_conn['oracle_encoding']) ? $arr_conn['oracle_encoding'] : "";
        $mysql_encoding            = isset($arr_conn['mysql_encoding']) ? $arr_conn['mysql_encoding'] : "";
        $str_db2_autocommit        = isset($arr_conn['db2_autocommit']) ? $arr_conn['db2_autocommit'] : "";
        $str_db2_i5_lib            = isset($arr_conn['db2_i5_lib']) ? $arr_conn['db2_i5_lib'] : "";
        $str_db2_i5_naming         = isset($arr_conn['db2_i5_naming']) ? $arr_conn['db2_i5_naming'] : "";
        $str_db2_i5_commit         = isset($arr_conn['db2_i5_commit']) ? $arr_conn['db2_i5_commit'] : "";
        $str_db2_i5_query_optimize = isset($arr_conn['db2_i5_query_optimize']) ? $arr_conn['db2_i5_query_optimize'] : "";
        $str_date_separator        = isset($arr_conn['date_separator']) ? $arr_conn['date_separator'] : "";
        $str_use_persistent        = isset($arr_conn['use_persistent']) ? $arr_conn['use_persistent'] : "";
        $str_use_schema            = isset($arr_conn['use_schema']) ? $arr_conn['use_schema'] : "";
		
        $use_ssl                   = isset($arr_conn['use_ssl']) ? $arr_conn['use_ssl'] : "N";
        $mysql_ssl_key             = isset($arr_conn['mysql_ssl_key']) ? $arr_conn['mysql_ssl_key'] : "";
        $mysql_ssl_cert            = isset($arr_conn['mysql_ssl_cert']) ? $arr_conn['mysql_ssl_cert'] : "";
        $mysql_ssl_capath          = isset($arr_conn['mysql_ssl_capath']) ? $arr_conn['mysql_ssl_capath'] : "";
        $mysql_ssl_ca              = isset($arr_conn['mysql_ssl_ca']) ? $arr_conn['mysql_ssl_ca'] : "";

        $oracle_type              = isset($arr_conn['oracle_type']) ? $arr_conn['oracle_type'] : "";


        if (!extension_loaded($this->DbModule($str_dbms)))
        {
            $str_db_err = 'error_profile_test_module';
        }
        else
        {
            include_once $nm_config['path_prod'] . '../../third/adodb/adodb.inc.php';
            $arrExtraArgs              = array();
            $str_execute_after_connect = "";
			$str_charset               = "";

            $bol_persistent = false;
            if($str_use_persistent == "Y")
            {
            	$bol_persistent = true;
            }
			$obj_db = ADONewConnection($this->DbAdodbModule($str_dbms));
            $str_dbms = $this->nm_db_sc_module($str_dbms);
            if ('ado_mssql' == $str_dbms)
            {
                $str_host = 'PROVIDER=MSDASQL;DRIVER={SQL Server};'
                          . 'SERVER='   . str_replace(":", ",", $str_host) . ';'
                          . 'UID='      . $str_user . ';'
                          . 'PWD='      . $str_pass . ';'
                          . 'DATABASE=' . $str_base . ';';
                $str_user = '';
                $str_pass = '';
                $str_base = '';
            }
            else if ('adooledb_mssql' == $str_dbms)
            {
                $str_host = 'PROVIDER=SQLOLEDB;'
                          . 'Data Source='   . str_replace(":", ",", $str_host) . ';'
                          . 'uid='      . $str_user . ';'
                          . 'pwd='      . $str_pass . ';'
                          . 'DATABASE=' . $str_base . ';';
                $str_user = '';
                $str_pass = '';
                $str_base = '';
            }
            elseif ('db2' == $str_dbms)
            {
            	$arrExtraArgs = array();
            	if(!empty($str_db2_autocommit))
            	{
            		$arrExtraArgs['autocommit']        = (int) $str_db2_autocommit;
            	}
            	if(!empty($str_db2_i5_lib))
            	{
            		$arrExtraArgs['i5_lib']            = $str_db2_i5_lib;
            	}
            	if(!empty($str_db2_i5_naming))
            	{
            		$arrExtraArgs['i5_naming']         = (int) $str_db2_i5_naming;
            	}
            	if(!empty($str_db2_i5_commit))
            	{
            		$arrExtraArgs['i5_commit']         = (int) $str_db2_i5_commit;
            	}
            	if(!empty($str_db2_i5_query_optimize))
            	{
            		$arrExtraArgs['i5_query_optimize'] = (int) $str_db2_i5_query_optimize;
            	}

		        $str_host  = $str_host;
		    	$str_user  = $str_user;
		        $str_pass  = $str_pass;
		        $str_base  = $str_base;
            }
			elseif ($str_dbms == "db2_odbc")
			{
				$str_port = "50000";

				if(strpos($str_host, ":") !== false)
				{
					$arr_tmp_list_change = explode(":", $str_host);
					list($str_host, $str_port) = $arr_tmp_list_change;
				}

				$str_host  = "driver={IBM db2 odbc DRIVER};Database=". $str_base .";hostname=". $str_host .";port=". $str_port .";protocol=TCPIP;";
				$str_host .= "uid=". $str_user ."; pwd=" . $str_pass;
				$str_user  = '';
				$str_pass  = '';
				$str_base  = '';
			}
            elseif ('postgres' == $str_dbms || 'postgres7' == $str_dbms || 'postgres8' == $str_dbms || 'postgres64' == $str_dbms)
			{
				if(!empty($postgres_encoding))
            	{
            		$str_execute_after_connect = "SET CLIENT_ENCODING TO '". $postgres_encoding ."'";
            		$str_charset = $postgres_encoding;
            	}

				$str_host  = $str_host;
		    	$str_user  = $str_user;
		        $str_pass  = $str_pass;
		        $str_base  = $str_base;
			}
            elseif ('oracle' == $str_dbms || 'oci' == $str_dbms || 'oci8' == $str_dbms || 'oci805' == $str_dbms || 'oci8po' == $str_dbms)
			{
				if(!empty($oracle_encoding))
            	{
            		$obj_db->charSet = $oracle_encoding;
            	}

                if(isset($oracle_type) && !empty($oracle_type))
                {
                    if($oracle_type == 'sid')
                    {
                        $sid_default = "orcl";
                        $port        = "1521";
                        $server      = $str_base;
                        if(strpos($str_base, "/") !== false)
                        {
                            $server      = substr($str_base, 0, strpos($str_base, "/"));
                            $sid_default = substr($str_base, strpos($str_base, "/")+1);
                        }
                        if(strpos($server, ":") !== false)
                        {
                            list($server, $port) = explode(":", $server);
                        }
                        $str_base = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ". $server .")(PORT = ". $port .")))(CONNECT_DATA=(SID=". $sid_default .")))";
                    }
                }

				$str_host  = $str_host;
		    	$str_user  = $str_user;
		        $str_pass  = $str_pass;
		        $str_base  = $str_base;
			}
            elseif ('pdosqlite' == $str_dbms)
            {
                $str_host = "sqlite:" . $str_host;
            }
            elseif ('pdo_informix' == $str_dbms)
            {
            	$str_host  = $str_host;
		    	$str_user  = $str_user;
		        $str_pass  = $str_pass;
		        $str_base  = $str_base;

		        if(empty($str_host) && !empty($str_base))
		        {
		        	$str_host = "informix:DSN=" . $str_host;
		        	$str_base = "";
		        }else
		        {
		        	$str_port   = "9088";
			    	$str_server = "";
			    	if(strpos($str_host, ":") !== false)
			    	{
			    		$arr_tmp_list_change = explode(":", $str_host);
			    		list($str_host, $str_port) = $arr_tmp_list_change;
			    	}
		        	if(strpos($str_host, "\\") !== false)
			    	{
			    		$arr_tmp_list_change = explode("\\", $str_host);
			    		list($str_host, $str_server) = $arr_tmp_list_change;
			    	}
		        	$str_host = "informix:host=". $str_host ."; service=". $str_port ."; database=". $str_base ."; server=". $str_server ."; protocol=onsoctcp; EnableScrollableCursors=1";
		        }
            }
            elseif ('pdo_mysql' == $str_dbms)
            {
            	if(!empty($mysql_encoding))
            	{
            		$str_execute_after_connect = "SET NAMES '". $mysql_encoding ."'";
					$str_charset = $mysql_encoding;
            	}

            	//$str_host = $servidor;
		    	$port = "";
				if(strpos($str_host, ":") !== false)
				{
					$arr_tmp_list_change = explode(":", $str_host);
					list($str_host, $port) = $arr_tmp_list_change;
				}

			    $str_host = "mysql:host=" . $str_host;
			    if(!empty($port))
			    {
			    	$str_host .= ";port=" . $port;
			    }
				if($use_ssl == 'Y')
				{
					if(!empty($mysql_ssl_key))
					{
						$arrExtraArgs[ PDO::MYSQL_ATTR_SSL_KEY ] = $mysql_ssl_key;
					}
					if(!empty($mysql_ssl_cert))
					{
						$arrExtraArgs[ PDO::MYSQL_ATTR_SSL_CERT ] = $mysql_ssl_cert;
					}
					if(!empty($mysql_ssl_ca))
					{
						$arrExtraArgs[ PDO::MYSQL_ATTR_SSL_CA ] = $mysql_ssl_ca;
					}
					if(!empty($mysql_ssl_capath))
					{
						$arrExtraArgs[ PDO::MYSQL_ATTR_SSL_CAPATH ] = $mysql_ssl_capath;
					}
					if(!empty($mysql_ssl_cipher))
					{
						$arrExtraArgs[ PDO::MYSQL_ATTR_SSL_CIPHER ] = $mysql_ssl_cipher;
					}

					if(empty($mysql_ssl_key) || empty($mysql_ssl_cert) || empty($mysql_ssl_ca))
	                {
	                    //dados bebos e desabiilta o mysql para verificar os certificados
	                    if(empty($mysql_ssl_key))
	                    {
	                        $arrExtraArgs[ PDO::MYSQL_ATTR_SSL_KEY ] = "client-key.pem";
	                    }
	                    if(empty($mysql_ssl_cert))
	                    {
	                        $arrExtraArgs[ PDO::MYSQL_ATTR_SSL_CERT ] = "client-cert.pem";
	                    }
	                    if(empty($mysql_ssl_ca))
	                    {
	                        $arrExtraArgs[ PDO::MYSQL_ATTR_SSL_CA ] = "server-ca.pem";
	                    }
	                    $arrExtraArgs[ PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT ] = false;
	                }
				}

            	$str_user  = $str_user;
		        $str_pass  = $str_pass;
		        $str_base  = $str_base;
            }
            elseif ('pdo_firebird' == $str_dbms)
            {
            	//$str_host = $servidor;
		    	$port = "";
				if(strpos($str_host, ":") !== false)
				{
					$arr_tmp_list_change = explode(":", $str_host);
					list($str_host, $port) = $arr_tmp_list_change;
				}

			    $str_host = "firebird:dbname=" . $str_host;
			    if(!empty($port))
			    {
			    	$str_host .= "/" . $port;
			    }
			    if(!empty($str_base))
			    {
			    	$str_host .= ":" . $str_base;
			    }

            	$str_user  = $str_user;
		        $str_pass  = $str_pass;
		        $str_base  = "";
            }
            elseif ('pdo_pgsql' == $str_dbms)
            {
            	if(!empty($postgres_encoding))
            	{
            		$str_execute_after_connect = "SET CLIENT_ENCODING TO '". $postgres_encoding ."'";
					$str_charset = $postgres_encoding;
            	}

            	//$str_host = $servidor;
		    	$port = "";
				if(strpos($str_host, ":") !== false)
				{
					$arr_tmp_list_change = explode(":", $str_host);
					list($str_host, $port) = $arr_tmp_list_change;
				}

			    $str_host = "pgsql:host=" . $str_host;
			    if(!empty($port))
			    {
			    	$str_host .= ";port=" . $port;
			    }

            	$str_user  = $str_user;
		        $str_pass  = $str_pass;
		        $str_base  = $str_base;
            }
            elseif ('pdo_sqlsrv' == $str_dbms)
            {
	           $port = "";
               if(strpos($str_host, ":") !== false)
               {
                   $arr_tmp_list_change = explode(":", $str_host);
                   list($str_host, $port) = $arr_tmp_list_change;
               }

               $str_host = "sqlsrv:ConnectionPooling=0;Server=" . $str_host;
               if(!empty($port))
               {
                   $str_host .= "," . $port;
               }
               if(!empty($str_base))
               {
                   $str_host .= ";Database=" . $str_base;
               }

               $str_base  = "";

            }
            elseif ('pdo_dblib' == $str_dbms || 'pdo_sybase_dblib' == $str_dbms)
            {
	           $str_host = "dblib:host=" . $str_host;
               if(!empty($str_base))
               {
                   $str_host .= ";dbname=" . $str_base;
               }

               $str_base  = "";

            }
            elseif ('pdo_oracle' == $str_dbms)
            {
	           $str_host = "oci:dbname=" . $str_base;
	           if(!empty($oracle_encoding))
               {
            		$str_host .= ";charset=" . $oracle_encoding;
               }

                if(isset($oracle_type) && !empty($oracle_type))
                {
                    if($oracle_type == 'sid')
                    {
                        $sid_default = "orcl";
                        $port        = "1521";
                        $server      = $str_base;
                        if(strpos($str_base, "/") !== false)
                        {
                            $server      = substr($str_base, 0, strpos($str_base, "/"));
                            $sid_default = substr($str_base, strpos($str_base, "/")+1);
                        }
                        if(strpos($server, ":") !== false)
                        {
                            list($server, $port) = explode(":", $server);
                        }
                        $str_host = "oci:dbname=(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ". $server .")(PORT = ". $port .")))(CONNECT_DATA=(SID=". $sid_default .")))";

                        $tmp = $oracle_encoding;
                        if(!empty($tmp))
                        {
                            $str_host .= ";charset=" . $tmp;
                            $oracle_encoding = "";
                        }
                    }
                }
               
               $str_base  = "";
            }
            elseif ('pdo_odbc' == $str_dbms || 'pdo_sybase_odbc' == $str_dbms || 'pdo_db2_odbc' == $str_dbms || 'pdo_progress_odbc' == $str_dbms)
            {
	           $str_host = "odbc:host=" . $str_host;
               
               $str_base  = "";

            }
            elseif ('pdo_ibm' == $str_dbms)
            {
	           $port = "";
	           if(strpos($str_host, ":") !== false)
	           {
	               $arr_tmp_list_change = explode(":", $str_host);
	               list($str_host, $port) = $arr_tmp_list_change;
	           }

	           $str_host = "ibm:HOSTNAME=" . $str_host;
	           if(!empty($str_base))
               {
                   $str_host .= ";DATABASE=" . $str_base;
               }
               if(!empty($port))
	           {
	               $str_host .= ";PORT=" . $port;
	           }
               
               $str_base  = "";

            }
            elseif ('firebird' == $str_dbms)
            {
	           $str_host = str_replace(":", "/", $str_host);
            }
            elseif ('mssql' == $str_dbms || 'mssqlnative' == $str_dbms)
            {
	           $str_host = str_replace(":", ",", $str_host);
            }
            elseif ('mysql' == $str_dbms || 'mysqli' == $str_dbms || 'mysqlt' == $str_dbms)
			{
				if(!empty($mysql_encoding))
            	{
            		$str_execute_after_connect = "SET NAMES '". $mysql_encoding ."'";
					$str_charset = $mysql_encoding;
            	}
				
				if($use_ssl == 'Y')
				{
                    if($str_dbms == 'mysqli')
                    {
                        $obj_db->clientFlags = MYSQLI_CLIENT_SSL;
                    }
                    else
                    {
                        $obj_db->clientFlags = MYSQL_CLIENT_SSL;
                    }
				}

				$str_host  = $str_host;
		    	$str_user  = $str_user;
		        $str_pass  = $str_pass;
		        $str_base  = $str_base;
			}

            /* Cria nova conexao ADOdb */
            set_error_handler('nm_prod_error_handler');

            if($bol_persistent)
		    {
		    	$obj_db->PConnect($str_host, $str_user, $str_pass, $str_base, $arrExtraArgs, $str_charset);
		    }else
		    {
		    	$obj_db->Connect($str_host, $str_user, $str_pass, $str_base, false, $arrExtraArgs, $str_charset);
		    }

		    if(!empty($str_execute_after_connect))
		    {
		    	$obj_db->Execute($str_execute_after_connect);
		    }

            /* Verifica sucesso da conexao */
            if (FALSE != $obj_db->_connectionID)
            {
                if ('interbase' == $this->DbType($str_dbms))
                {
                    if (function_exists('ibase_timefmt'))
                	{
                		ibase_timefmt('%Y-%m-%d %H:%M:%S');
                	}else
                	{
                		ini_set("ibase.dateformat"     , '%Y-%m-%d %H:%M:%S');
                		ini_set("ibase.timestampformat", '%Y-%m-%d %H:%M:%S');
						ini_set("ibase.timeformat"     , '%H:%M:%S');
                	}
                }
                elseif ('sybase' == $str_dbms)
                {
                    sybase_min_client_severity(11);
                    sybase_min_server_severity(11);
                }

                if (nm_prod_error_filter($obj_db->ErrorMsg()))
                {
                    $str_db_err = $obj_db->ErrorMsg();
                }
                else
                {
                    $bol_conn = TRUE;
                }
            }
            else
            {
                $str_db_err = "Unable to connect: " . $obj_db->ErrorMsg();
            }
		}

		return ($bol_conn ? "" : $str_db_err);

    }//TestConn

    function SaveConn($arr_ini)
    {
    	global $nm_config;

		$prod_ini_file = $nm_config['path_conf'] . 'prod.config.php';

	    if (!is_dir($nm_config['path_conf']))
	    {
	        nm_dir_create($nm_config['path_conf']);
	    }

		$_SESSION['nm_session']['cache']['prod_v8'] = $arr_ini;

		file_put_contents($prod_ini_file, "<?php /*" . serialize($arr_ini) . "*/ ?>");
    }//SaveConn

	function DbModule($v_str_dbms)
	{
	    switch ($this->nm_db_sc_module($v_str_dbms))
	    {
	        /* ADO */
	        case 'ado':
	        case 'ace_access':
            case 'ado_access':
	        case 'ado_mssql':
            case 'adooledb_mssql':
	            if (5 == nm_php_version())
	            {
	                return 'com_dotnet';
	            }
	            else
	            {
	                return 'com';
	            }
	            break;
	        /* Frontbase */
	        case 'fbsql':
	            return 'fbsql';
	            break;
	        /* IBM Db2 */
	        case 'db2':
	        case 'db2_odbc':
	            return 'ibm_db2';
	            break;
	        /* Informix */
	        case 'informix':
	        case 'informix72':
	            return 'informix';
	            break;
	        /* Interbase */
	        case 'borland_ibase':
	        case 'firebird':
	        case 'ibase':
	            return 'interbase';
	            break;
	        case 'pdo_firebird':
	            return 'pdo_firebird';
	            break;
	        /* MS SQL Server */
	        case 'mssql':
	        case 'mssqlpo':
	            return 'mssql';
	            break;
	        /* MS SQL Server Nativo SRV */
	        case 'mssqlnative':
	            return 'sqlsrv';
	            break;
	        /* MySQL */
	        case 'maxsql':
	        case 'mysql':
	        case 'mysqlt':
	            return 'mysql';
	            break;
	        /* ODBC */
	        case 'mysqli':
	            return 'mysqli';
	            break;
	        /* ODBC */
	        case 'access':
	        case 'odbc_db2':
	        case 'odbc_db2v6':
	        case 'odbc':
	        case 'odbc_access':
	        case 'odbc_mssql':
	        case 'odbc_oracle':
	        case 'sapdb':
	        case 'sqlanywhere':
	        case 'vfp':
	        case 'progress':
	            return 'odbc';
	            break;
	        /* Oracle */
	        case 'oci8':
	        case 'oci805':
	        case 'oci8po':
	            return 'oci8';
	            break;
	        case 'oracle':
	            return 'oracle';
	            break;
	        /* SQLite PDO */
	        case 'pdosqlite':
	            return 'pdo_sqlite';
	            break;
	        case 'pdo_informix':
	            return 'pdo_informix';
	            break;
	        case 'pdo_mysql':
	            return 'pdo_mysql';
	            break;
	        case 'pdo_pgsql':
	            return 'pdo_pgsql';
	            break;
	        case 'pdo_sqlsrv':
	            return 'pdo_sqlsrv';
	            break;
	        case 'pdo_dblib':
	        case 'pdo_sybase_dblib':
	            return 'pdo_dblib';
	            break;
	        case 'pdo_sybase_odbc':
	        case 'pdo_db2_odbc':
	        case 'pdo_progress_odbc':
	            return 'pdo_odbc';
	            break;
	        case 'pdo_ibm':
	            return 'pdo_ibm';
	            break;
	        case 'pdo_oracle':
	            return 'pdo_oci';
	            break;
	        /* PostGreSQL */
	        case 'postgres':
	        case 'postgres64':
	        case 'postgres7':
	            return 'pgsql';
	            break;
	        /* SQLite */
	        case 'sqlite':
	            return 'sqlite';
	            break;
	        /* SQLite */
	        case 'sqlite3':
	            return 'sqlite3';
	            break;
	        /* Sybase */
	        case 'sybase':
	            return 'sybase_ct';
	            break;
	        /* Outros */
	        default:
	            return FALSE;
	            break;
	    }
	} // nm_db_module

	/**
	 * Retorna o modulo do adodb.
	 *
	 * Retorna o modulo do adodb responsavel pela comunicacao com o banco de dados.
	 *
	 * @access  public
	 * @param   string  $v_str_dbms  Banco de dados.
	 * @return  string  $str_result  Modulo do PHP.
	 */
	function DbAdodbModule($v_str_dbms)
	{
	    switch ($this->nm_db_sc_module($v_str_dbms))
	    {
	        /* DB2 */
	        case 'db2_odbc':
	            return 'db2';
	            break;
	        /* DB2 */
	        case 'odbc_db2v6':
	            return 'odbc_db2';
	            break;
	        /* SQLite PDO */
	        case 'pdosqlite':
	        case 'pdo_informix':
	        case 'pdo_mysql':
	        case 'pdo_pgsql':
	        case 'pdo_sqlsrv':
	        case 'pdo_dblib':
	        case 'pdo_sybase_odbc':
	        case 'pdo_firebird':
	        case 'pdo_oracle':
	        case 'pdo_sybase_dblib':
	        case 'pdo_db2_odbc':
	        case 'pdo_ibm':
	        case 'pdo_progress_odbc':
	            return 'pdo';
	            break;
	        case 'dbf':
	        case 'filemaker':
	        case 'progress':
	            return 'odbc';
	            break;
	        /* Outros */
	        default:
	            return $this->nm_db_sc_module($v_str_dbms);
	            break;
	    }
	} // DbAdodbModule

    function getSgdbGroupByGroup()
    {
        $arr_sgdb = $this->GetSGBDS();

        $arr_group = [
                        'azure' =>
                            [
                                'azure_mysql' => $arr_sgdb['azure_mysql']['azure_mysql'],
                                'azure_postgres' => $arr_sgdb['azure_postgres']['azure_postgres'],
                                'azure_mssql' => $arr_sgdb['azure_mssql']['azure_mssql'],
                            ],
                        'googlecloud' =>
                            [
                                'googlecloud_mysql' => $arr_sgdb['googlecloud_mysql']['googlecloud_mysql'],
                                'googlecloud_postgres' => $arr_sgdb['googlecloud_postgres']['googlecloud_postgres'],
                                'googlecloud_mssql' => $arr_sgdb['googlecloud_mssql']['googlecloud_mssql'],
                            ],
                        'oraclecloud' =>
                            [
                                'oraclecloud_oracle' => $arr_sgdb['oraclecloud_oracle']['oraclecloud_oracle'],
                            ],
                        'amazonrds' =>
                            [
                                'amazonrds_mysql' => $arr_sgdb['amazonrds_mysql']['amazonrds_mysql'],
                                'amazonrds_postgres' => $arr_sgdb['amazonrds_postgres']['amazonrds_postgres'],
                                'amazonrds_mssql' => $arr_sgdb['amazonrds_mssql']['amazonrds_mssql'],
                                'amazonrds_oracle' => $arr_sgdb['amazonrds_oracle']['amazonrds_oracle'],
                            ],
                    ];

        return $arr_group;
    }
    function getSgdbGroupByDrive()
    {
        $arr_group = [
                        'azure_mysql' => 'azure',
                        'azure_postgres' => 'azure',
                        'azure_mssql' => 'azure',
                        'googlecloud_mysql' => 'googlecloud',
                        'googlecloud_postgres' => 'googlecloud',
                        'googlecloud_mssql' => 'googlecloud',
                        'oraclecloud_oracle' => 'oraclecloud',
                        'amazonrds_mysql' => 'amazonrds',
                        'amazonrds_postgres' => 'amazonrds',
                        'amazonrds_mssql' => 'amazonrds',
                        'amazonrds_oracle' => 'amazonrds',

        ];

        return $arr_group;
    }

    //qual o tipo de conexao para o sc(grupo)
    function nm_db_sc_type($v_str_dbms)
    {
        if(isset($v_str_dbms) && !empty($v_str_dbms) && is_string($v_str_dbms))
        {
            if(substr($v_str_dbms, 0, 6) == "azure_")
            {
                $v_str_dbms =substr($v_str_dbms, 6);
            }
            elseif(substr($v_str_dbms, 0, 10) == "amazonrds_")
            {
                $v_str_dbms =substr($v_str_dbms, 10);
            }
            elseif(substr($v_str_dbms, 0, 12) == "googlecloud_")
            {
                $v_str_dbms =substr($v_str_dbms, 12);
            }
            elseif(substr($v_str_dbms, 0, 12) == "oraclecloud_")
            {
                $v_str_dbms =substr($v_str_dbms, 12);
            }
        }
        return $v_str_dbms;
    }

    //qual modulo do drive se comportara como qual modulo do sc(aqui é o drive em si)
    function nm_db_sc_module($v_str_dbms)
    {
        if(isset($v_str_dbms) && !empty($v_str_dbms) && is_string($v_str_dbms))
        {
            if(substr($v_str_dbms, 0, 6) == "azure_")
            {
                $v_str_dbms =substr($v_str_dbms, 6);
            }
            elseif(substr($v_str_dbms, 0, 10) == "amazonrds_")
            {
                $v_str_dbms =substr($v_str_dbms, 10);
            }
            elseif(substr($v_str_dbms, 0, 12) == "googlecloud_")
            {
                $v_str_dbms =substr($v_str_dbms, 12);
            }
            elseif(substr($v_str_dbms, 0, 12) == "oraclecloud_")
            {
                $v_str_dbms =substr($v_str_dbms, 12);
            }
        }
        return $v_str_dbms;
    }

	function DbType($v_str_dbms)
	{
		switch ($v_str_dbms)
	    {
	        /* Access  */
	        case 'access':
	        case 'ace_access':
            case 'ado_access':
	            return 'access';
	        break;
	        /* ADO */
	        case 'ado':
	            return 'ado';
	        break;
	        /* DB2 */
	        case 'db2':
	        case 'db2_odbc':
	        case 'odbc_db2':
	        case 'odbc_db2v6':
	        case 'pdo_db2_odbc':
	        case 'pdo_ibm':
	            return 'db2';
	        break;
	        /* Frontbase */
	        case 'fbsql':
	            return 'fbsql';
	        break;
	        /* Informix */
	        case 'informix':
	        case 'pdo_informix':
	        case 'informix72':
	            return 'informix';
	        break;
	        /* Interbase */
	        case 'borland_ibase':
	        case 'firebird':
	        case 'ibase':
	        case 'pdo_firebird':
	            return 'interbase';
	        break;
	        /* MS-SQL Server */
	        case 'ado_mssql':
            case 'adooledb_mssql':
	        case 'mssql':
	        case 'mssqlnative':
	        case 'mssqlpo':
	        case 'pdo_sqlsrv':
	        case 'odbc_mssql':
	        case 'pdo_dblib':
	            return 'mssql';
	        break;
	        /* MySQL */
	        case 'mysql':
	        case 'mysqlt':
	        case 'pdo_mysql':
	        case 'mysqli':
	            return 'mysql';
	        break;
	        /* ODBC */
	        case 'odbc':
	            return 'odbc';
	        break;
	        /* Oracle */
	        case 'oci8':
	        case 'oci805':
	        case 'oci8po':
	        case 'odbc_oracle':
	        case 'oracle':
	        case 'pdo_oracle':
	            return 'oracle';
	        break;
	        /* PostGreSQL */
	        case 'postgres':
	        case 'postgres64':
	        case 'postgres7':
	        case 'pdo_pgsql':
	            return 'postgres';
	        break;
	        /* SQLite */
	        case 'pdosqlite':
	        case 'sqlite':
	            return 'sqlite';
	        break;
	        /* Sybase */
	        case 'sqlanywhere':
	        case 'sybase':
	        case 'pdo_sybase_odbc':
	        case 'pdo_sybase_dblib':
	            return 'sybase';
	        break;
	        case 'progress':
	        case 'pdo_progress_odbc':
	            return 'progress';
	        break;
	        /* Visual Fox Pro */
	        case 'vfp':
	            return 'vfp';
	        break;
            case 'azure_pdo_mysql':
            case 'azure_mysqli':
            case 'azure_mysqlt':
            case 'azure_mysql':
                return 'azure_mysql';
                break;
            case 'azure_pdo_pgsql':
            case 'azure_postgres7':
            case 'azure_postgres64':
            case 'azure_postgres':
                return 'azure_postgres';
                break;
            case 'azure_ado_mssql':
            case 'azure_adooledb_mssql':
            case 'azure_mssql':
            case 'azure_mssqlnative':
            case 'azure_mssqlpo':
            case 'azure_pdo_sqlsrv':
            case 'azure_odbc_mssql':
            case 'azure_pdo_dblib':
                return 'azure_mssql';
            case 'googlecloud_pdo_mysql':
            case 'googlecloud_mysqli':
            case 'googlecloud_mysqlt':
            case 'googlecloud_mysql':
                return 'googlecloud_mysql';
                break;
            case 'googlecloud_pdo_pgsql':
            case 'googlecloud_postgres7':
            case 'googlecloud_postgres64':
            case 'googlecloud_postgres':
                return 'googlecloud_postgres';
                break;
            case 'googlecloud_ado_mssql':
            case 'googlecloud_adooledb_mssql':
            case 'googlecloud_mssql':
            case 'googlecloud_mssqlnative':
            case 'googlecloud_mssqlpo':
            case 'googlecloud_pdo_sqlsrv':
            case 'googlecloud_odbc_mssql':
            case 'googlecloud_pdo_dblib':
                return 'googlecloud_mssql';
            case 'oraclecloud_oci8':
            case 'oraclecloud_oci805':
            case 'oraclecloud_oci8po':
            case 'oraclecloud_odbc_oracle':
            case 'oraclecloud_oracle':
            case 'oraclecloud_pdo_oracle':
                return 'oraclecloud_oracle';
                break;
            case 'amazonrds_pdo_mysql':
            case 'amazonrds_mysqli':
            case 'amazonrds_mysqlt':
            case 'amazonrds_mysql':
                return 'amazonrds_mysql';
                break;
            case 'amazonrds_pdo_pgsql':
            case 'amazonrds_postgres7':
            case 'amazonrds_postgres64':
            case 'amazonrds_postgres':
                return 'amazonrds_postgres';
                break;
            case 'amazonrds_ado_mssql':
            case 'amazonrds_adooledb_mssql':
            case 'amazonrds_mssql':
            case 'amazonrds_mssqlnative':
            case 'amazonrds_mssqlpo':
            case 'amazonrds_pdo_sqlsrv':
            case 'amazonrds_odbc_mssql':
            case 'amazonrds_pdo_dblib':
                return 'amazonrds_mssql';
            case 'amazonrds_oci8':
            case 'amazonrds_oci805':
            case 'amazonrds_oci8po':
            case 'amazonrds_odbc_oracle':
            case 'amazonrds_oracle':
            case 'amazonrds_pdo_oracle':
                return 'amazonrds_oracle';
                break;
	        /* Outros */
	        default:
	            return FALSE;
	        break;
	    }
	} // DbType


    function GetSGBDVersions()
    {
        global $nm_config;

		$arr_return =
            [
				    'access' =>
                        [
				            'ace_access' => 'MS Access ADO',
				            'access' => 'MS Access ODBC'
                        ],

				    'db2' =>
                        [
				            'pdo_db2_odbc' => 'DB2 PDO ODBC',
				            'pdo_ibm'      => 'PDO IBM',
				            'db2'          => 'DB2',
				            'db2_odbc'     => 'DB2 Native ODBC',
				            'odbc_db2'     => 'DB2 Generic ODBC',
				            'odbc_db2v6'   => 'DB2 Generic ODBC 6 or Lower'
                        ],

				    'firebird' =>
                        [
				            'firebird'     => 'Firebird',
				            'pdo_firebird' => 'Firebird PDO'
                        ],

				    'ibase' =>
                        [
				            'borland_ibase' => 'Interbase 6.5 or Higher',
				            'ibase' => 'Interbase',
                            'pdo_firebird' => 'Firebird PDO'
                        ],

				    'informix' =>
                        [
				            'informix' => 'Informix',
				            'pdo_informix' => 'Informix PDO',
				            'informix72' => 'Informix 7.2 or Lower'
                        ],

				    'maxsql' =>
                        [
				            'maxsql' => 'MaxSQL'
                        ],

				    'mssql' =>
                        [
				            'mssql' => 'MSSQL Server',
				            'pdo_sqlsrv' => 'MSSQL Server NATIVE SRV PDO',
				            'mssqlnative' => 'MSSQL Server NATIVE SRV',
				            'odbc_mssql' => 'MSSQL Server ODBC',
				            'pdo_dblib' => 'DBLIB'
                        ],

				    'mysql' =>
                        [
                            'pdo_mysql' => 'MySQL PDO',
					        'mysqli' => 'MySQLi',
					        'mysqlt' => 'MySQL (Transaction)',
				            'mysql' => 'MySQL'
                        ],

				    'odbc' =>
                        [
				            'odbc' => 'Generic ODBC'
                        ],

				    'oracle' =>
                        [
				            'pdo_oracle' => 'Oracle PDO',
				            'oci805' => 'Oracle 8.0.5 or Higher',
				            'oci8' => 'Oracle 8',
				            'oci8po' => 'Oracle 8 Portable',
				            'odbc_oracle' => 'Oracle ODBC'
                        ],

				    'postgres' =>
                        [
				            'postgres7'  => 'PostgreSQL 7 or Higher',
				            'postgres'   => 'PostgreSQL',
				            'pdo_pgsql'  => 'PostgreSQL PDO',
				            'postgres64' => 'PostgreSQL 6.4'
                        ],

				    'progress' =>
                        [
				            'progress' => 'Progress'
                        ],

				    'sqlite' =>
                        [
				            'pdosqlite' => 'SQLite PDO',
				            'sqlite' => 'SQLite',
                        ],

				    'sybase' =>
                        [
				            'pdo_sybase_dblib' => 'Sybase PDO DBLIB',
				            'pdo_sybase_odbc' => 'Sybase PDO ODBC',
				            'sybase' => 'Sybase',
                        ],
            ];

        $php_ver = explode(".", phpversion());
        if(isset($php_ver[0]) && $php_ver[0] >= 7)
        {
            unset($arr_return['mysql']['mysql']);
            unset($arr_return['mysql']['mysqlt']);
        }

        if(isset($php_ver[0]) && $php_ver[0] >= 8)
        {
            unset($arr_return['firebird']['firebird']);
            unset($arr_return['ibase']['borland_ibase']);
            unset($arr_return['ibase']['ibase']);
        }

		if(isset($nm_config['os_code']))
        {
            if ($nm_config['os_code'] === 'windows')
            {
                unset($arr_return['mssql']['pdo_dblib']);
            }
            /*else
            {
                unset($arr_return['mssql']['mssqlnative']);
                unset($arr_return['mssql']['pdo_sqlsrv']);
                unset($arr_return['mssql']['odbc_mssql']);
                unset($arr_return['mssql']['mssql']);
            }*/
        }

		if ($arr_return)

        $arr_group = $this->getSgdbGroupByDrive();
        foreach($arr_group as $dbms=>$group)
        {
            if(isset($arr_return[ $this->nm_db_sc_type($dbms) ]))
            {
                foreach($arr_return[ $this->nm_db_sc_type($dbms) ] as $drive=>$desc)
                {
                    $arr_return[ $dbms ][ $group . "_" . $drive] = $desc;
                }
            }
        }

        return $arr_return;
    } // GetSGBDVersions


    function GetSGBDS()
    {

        $arr_ret = [
            'mysql' => [
                'mysql' => 'MySQL / MariaDB'
            ],
            'mssql' => [
                'mssql' => 'MSSQL Server'
            ],
            'postgres' => [
                'postgres' => 'PostgreSQL'
            ],
            'oracle' => [
                'oracle' => 'Oracle'
            ],
            'sqlite' => [
                'pdosqlite' => 'SQLite PDO',
                'sqlite' => 'SQLite',
            ],
            'progress' => [
                'progress' => 'Progress'
            ],
            'access' => [
                'access' => 'MS Access'
            ],
            'db2' => [
                'db2' => 'DB2'
            ],
            'firebird' => [
                'firebird' => 'Firebird'
            ],
            'ibase' => [
                'ibase' => 'Interbase'
            ],
            'informix' => [
                'informix' => 'Informix'
            ],
            'sybase' => [
                'sybase' => 'Sybase'
            ],
            'odbc' => [
                'odbc' => 'Generic ODBC'
            ],
            'azure' => [
                'azure' => 'Microsoft Azure'
            ],
            'azure_mysql' => [
                'azure_mysql' => 'MySQL'
            ],
            'azure_postgres' => [
                'azure_postgres' => 'Postgres'
            ],
            'azure_mssql' => [
                'azure_mssql' => 'MSSQL Server'
            ],
            'googlecloud' => [
                'googlecloud' => 'Google Cloud'
            ],
            'googlecloud_mysql' => [
                'googlecloud_mysql' => 'MySQL'
            ],
            'googlecloud_postgres' => [
                'googlecloud_postgres' => 'Postgres'
            ],
            'googlecloud_mssql' => [
                'googlecloud_mssql' => 'MSSQL Server'
            ],
            'oraclecloud' => [
                'oraclecloud' => 'Oracle Cloud'
            ],
            'oraclecloud_oracle' => [
                'oraclecloud_oracle' => 'Oracle'
            ],
            'amazonrds' => [
                'amazonrds' => 'Amazon RDS'
            ],
            'amazonrds_mysql' => [
                'amazonrds_mysql' => 'MySQL'
            ],
            'amazonrds_postgres' => [
                'amazonrds_postgres' => 'Postgres'
            ],
            'amazonrds_mssql' => [
                'amazonrds_mssql' => 'MSSQL Server'
            ],
            'amazonrds_oracle' => [
                'amazonrds_oracle' => 'Oracle'
            ],
        ];

        return $arr_ret;

    } // GetSGBDS
}
?>