<?php
use Kahlan\Filter\Filter;
use RRegeer\Reporters;

Filter::register('kahlan.teamcity', function() {
    $reporters = $this->reporters();
    $reporters->add('teamcity', new TeamcityReporter(['start' => $this->_start]));
});

Filter::apply($this, 'console', 'kahlan.teamcity');