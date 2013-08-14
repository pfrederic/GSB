<?
include("./scripts/parametres.php");

mysql_query("source /var/www/GSB/sql/PPE_GSB_base.sql");
echo "DONE 1"."\r\n";
mysql_query("source /var/www/GSB/sql/PPE_GSB_data.sql");
echo "DONE 2"."\r\n";
mysql_query("source /var/www/GSB/sql/PPE_GSB_modif.sql");
echo "DONE 3"."\r\n";
mysql_query("source /var/www/GSB/sql/PPE_GSB_modif_mdp.sql");
echo "DONE 4"."\r\n";
mysql_query("source /var/www/GSB/sql/PPE_GSB_data_dep.sql");
echo "DONE 5"."\r\n";
shell_exec("php /var/www/GSB/sql/recupDataPraticien.php");
echo "DONE 6"."\r\n";
shell_exec("php /var/www/GSB/sql/creaMotDePasse.php");
echo "DONE 7"."\r\n";
?>
