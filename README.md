### About this repo

I don't have any public repos, so this is just a WIP of a simple WordPress plugin. I will continue to develop this over time, but it isn't an actual product.

### Testing plugin with Lando

NOTE: if for any reason you cannot use Lando (setup problems, system requirements or personal preference) you can install and develop the plugin on any WordPress site. Please refer to the [Setting up the development environment manually](#-setting-up-the-development-environment-manually) section

- Install [Lando](https://docs.devwithlando.io/).
- Clone this repository locally. If you are using Windows, make sure you've set `git` to use UNIX line endings.
- In a terminal go to the directory of the local repository clone.
- Run `lando start`.
- Wait for a few minutes for everything to begin loading. Subsequent starts will be much faster but you’ll need to give it time for the very first start.
- You should see a `BOOMSHAKALAKA!!!` line
- In the `NGINX URLS` section of the output note the third URL (it should start with `http://teamscentrex.lndo.site` and maybe have a port).
- If the URL is different than `http://teamscentrex.lndo.site`, then run: `lando wp search-replace 'http://teamscentrex.lndo.site' '<URL>'`
- In order to visit the plugin’s interface, use the URL from above and append `/wp-admin/admin.php?page=teams`, both the username and the password should be `teams`.
- Logs are accessible via the [lando logs](https://docs.devwithlando.io/cli/logs.html) command. If you mostly care about PHP error log, a useful command is: `lando logs -s appserver -t -f`.
  Debugging PHP with XDebug

- If using Lando, configure your IDE to listen to XDebug on port 9000 and map the server's `/app/` directory to the root of this repository.

Profiling PHP with XDebug

- If using Lando, simply append `XDEBUG_PROFILE` param to either GET or POST parameters. The profiler will write to the root of this repository.

### Setting up the development environment manually

If you’d rather set up everything yourself, here is what you’ll need to setup:

- A local WordPress installation:
  - https://make.wordpress.org/core/handbook/tutorials/installing-a-local-server/
  - https://wordpress.org/support/article/how-to-install-wordpress/
- Some of the helpful tools include:
  - [MAMP](https://www.mamp.info/en/) for OSX
  - [WAMP](http://www.wampserver.com/en/) for Windows
  - [XAMPP](https://www.apachefriends.org/) - Windows, Mac, Linux
  - [Varying Vagrant Vagrants](https://varyingvagrantvagrants.org/), VVV – WordPress specific Vagrant configuration for Windows, Mac, Linux
  - [Local by Flywheel](https://localbyflywheel.com/)
- If you want to run the unit tests for the plugin, you will need also [phpunit + WordPress unit tests](https://make.wordpress.org/cli/handbook/plugin-unit-tests/).

### Running tests:

- If using Lando you can run `lando phpunit` or `lando phpunit ./tests/<php-file-with-tests>` in the main plugin directory.
- JavaScript tests: open `<site-host>/<URL-of-plugin-directory>/tests/test.html` (e.g. http://teamscentrex.lndo.site/wp-content/plugins/teams/tests/test.html) in your browser.
