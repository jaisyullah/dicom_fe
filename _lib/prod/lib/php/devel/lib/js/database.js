function nm_db_sc_type(dbms)
{
    if(dbms.substr(0, 6) == 'azure_')
    {
        dbms = dbms.substr(6);
    }
    else if(dbms.substr(0, 10) == 'amazonrds_')
    {
        dbms = dbms.substr(10);
    }
    else if(dbms.substr(0, 12) == 'googlecloud_')
    {
        dbms = dbms.substr(12);
    }
    else if(dbms.substr(0, 12) == 'oraclecloud_')
    {
        dbms = dbms.substr(12);
    }
    return dbms;
}