# YXZprivateServer
yet another implementation of private geometry dash server emulator

### warning: hard beta; still in development
- currently only gmd 2.2 is supported
- tested on php 8.3
- yeah

## setup
- upload everything from `src\backend` to the webserver
- import `src\db.sql` into the mysql database
- edit `geometrydash.exe` and change the links

## updating
- the core will fetch and notify in dashboard about available updates automatically
- replace the required files with the updated ones and import `updates\latest.sql`

## credits
- @Wyliemaster for gddocs
- @svlemogames for some cool stuff and a server where i can test my projects on lol
- @m41denx and FruitSpace for inspiration (spizdil nemnogo idey iz ghostcore lol)
- @Partur-dev also for some help