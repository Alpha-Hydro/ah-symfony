Description:
  Execute a migration to a specified version or the latest available version.

Usage:
  doctrine:migrations:migrate [options] [--] [<version>]

Arguments:
  version                                    The version number (YYYYMMDDHHMMSS) or alias (first, prev, next, latest) to migrate to. [default: "latest"]

Options:
      --write-sql[=WRITE-SQL]                The path to output the migration SQL file instead of executing it. Default to current working directory.
      --dry-run                              Execute the migration as a dry run.
      --query-time                           Time all the queries individually.
      --allow-no-migration                   Don't throw an exception if no migration is available (CI).
      --configuration[=CONFIGURATION]        The path to a migrations configuration file.
      --db-configuration[=DB-CONFIGURATION]  The path to a database connection configuration file.
      --db=DB                                The database connection to use for this command.
      --em=EM                                The entity manager to use for this command.
      --shard=SHARD                          The shard connection to use for this command.
  -h, --help                                 Display this help message
  -q, --quiet                                Do not output any message
  -V, --version                              Display this application version
      --ansi                                 Force ANSI output
      --no-ansi                              Disable ANSI output
  -n, --no-interaction                       Do not ask any interactive question
  -e, --env=ENV                              The Environment name. [default: "dev"]
      --no-debug                             Switches off debug mode.
  -v|vv|vvv, --verbose                       Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Help:
  The doctrine:migrations:migrate command executes a migration to a specified version or the latest available version:
  
      ./bin/console doctrine:migrations:migrate
  
  You can optionally manually specify the version you wish to migrate to:
  
      ./bin/console doctrine:migrations:migrate YYYYMMDDHHMMSS
  
  You can specify the version you wish to migrate to using an alias:
  
      ./bin/console doctrine:migrations:migrate prev
      These alias are defined : first, latest, prev, current and next
  
  You can specify the version you wish to migrate to using an number against the current version:
  
      ./bin/console doctrine:migrations:migrate current+3
  
  You can also execute the migration as a --dry-run:
  
      ./bin/console doctrine:migrations:migrate YYYYMMDDHHMMSS --dry-run
  
  You can output the would be executed SQL statements to a file with --write-sql:
  
      ./bin/console doctrine:migrations:migrate YYYYMMDDHHMMSS --write-sql
  
  Or you can also execute the migration without a warning message which you need to interact with:
  
      ./bin/console doctrine:migrations:migrate --no-interaction
  
  You can also time all the different queries if you wanna know which one is taking so long:
  
      ./bin/console doctrine:migrations:migrate --query-time
