#*/15 * * * * wget http://www.quoram.net/referentiel/quorami/SendToPostGre.php
#*/15 * * * * wget http://www.quoram.net/referentiel/quorami/SendToPostGreFitting.php
#0 22 * * * /var/lib/pgsql/backups/backup.sh postgres
#*/10 * * * * wget http://www.quoram.net/referentiel/quorami/AgreenMap/AgregratePGNew.php
#*/2 * * * * wget http://www.quoram.net/referentiel/quorami/AgreenMap/Session.php




    private static String urlPutEvent = "http://www.quoram.net/referentiel/quorami/put_all_enventv3.php";
