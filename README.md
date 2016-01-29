# kahlan-teamcity-reporter
Teamcity reporter for the [kahlan](https://github.com/crysalead/kahlan) bdd test framework.
The reporter will generate service tags for the test suites for [teamcity](https://www.jetbrains.com/teamcity/). For more information about the teamcity service tags take a look at the teamcity [site](https://confluence.jetbrains.com/display/TCD9/Build+Script+Interaction+with+TeamCity#BuildScriptInteractionwithTeamCity-BlocksofServiceMessages).

- [kahlan-teamcity-reporter](#kahlan-teamcity-reporter)
- [Install via composer](#install-via-composer)
- [Use the teamcity reporter](#use-the-teamcity-reporter)

# Install via composer
The reporter can be installed using composer. To install the latest version as a dev dependency:
```bash
composer require --dev rregeer/kahlan-teamcity-reporter
```

# Use the teamcity reporter
To use the reporter the correct configuration must be given to kahlan:
```bash
vendor/bin/kahlan --config=vendor/rregeer/kahlan-teamcity-reporter/src/teamcity-reporter-config.php
```
