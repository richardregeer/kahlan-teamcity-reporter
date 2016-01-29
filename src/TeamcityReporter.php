<?php

namespace RRegeer\Reporters;

class TeamcityReporter extends \Kahlan\Reporter\Terminal
{
    /**
     * Callback called on a suite start.
     *
     * @param object $report The report object of the whole spec.
     */
    public function suiteStart($report = null)
    {
        $messages = $report->messages();
        $testSuite = end($messages);
        $this->write("##teamcity[testSuiteStarted name='{$testSuite}']\n");
    }

    /**
     * Callback called after a suite execution.
     *
     * @param object $report The report object of the whole spec.
     */
    public function suiteEnd($report = null)
    {
        $messages = $report->messages();
        $testSuite = end($messages);
        $this->write("##teamcity[testSuiteFinished name='{$testSuite}']\n");
    }

    /**
     * Callback called on successful expectation.
     *
     * @param object $report An expect report object.
     */
    public function pass($report = null)
    {
        $messages = $report->messages();
        $test = end($messages);
        $this->write("##teamcity[testStarted name='{$test}' captureStandardOutput='false']\n");
        $this->write("##teamcity[testFinished name='{$test}' captureStandardOutput='false']\n");
    }

    /**
     * Callback called on failure.
     *
     * @param object $report An expect report object.
     */
    public function fail($report = null)
    {
        $messages = $report->messages();
        $params = $report->params();
        $actual = '';
        $expected = '';

        foreach ($params as $key => $value) {
            if (preg_match('~actual~', $key)) {
                $actual = $value;
            } elseif (preg_match('~expected~', $key)) {
                $expected = $value;
            }
        }

        $test = end($messages);
        $this->write("##teamcity[testStarted name='{$test}' captureStandardOutput='false']\n");
        $this->write("##teamcity[testFailed name='{$test}' message='expect->{$report->matcherName()}() failed in {$report->file()} ".
            "line {$report->line()}' captureStandardOutput='false' expected='{$expected}' actual='{$actual}']\n");
        $this->write("##teamcity[testFinished name='{$test}' captureStandardOutput='false']\n");
    }

    /**
     * Callback called when an exception occur.
     *
     * @param object $report An expect report object.
     */
    public function exception($report = null)
    {
        $messages = $report->messages();
        $test = end($messages);
        $this->write("##teamcity[testStarted name='{$test}' captureStandardOutput='false']\n");
        $this->write("##teamcity[testFailed name='{$test}' message='an uncaught exception has been thrown in " .
            "{$report->file()} line {$report->line()}' details='{$report->exception()}' captureStandardOutput='false']\n");
        $this->write("##teamcity[testFinished name='{$test}' captureStandardOutput='false']\n");
    }

    /**
     * Callback called on a skipped spec.
     *
     * @param object $report An expect report object.
     */
    public function skip($report = null)
    {
        $messages = $report->messages();
        $test = end($messages);
        $this->write("##teamcity[testIgnored name='{$test}' message='skipped']\n");
    }

    /**
     * Callback called when a `Kahlan\IncompleteException` occur.
     *
     * @param object $report An expect report object.
     */
    public function incomplete($report = null)
    {
        $messages = $report->messages();
        $test = end($messages);
        $this->write("##teamcity[testIgnored name='{$test}' message='incomplete']\n");
    }

    /**
     * Callback called at the end of specs processing.
     */
    public function end($results = [])
    {
        $time = round((microtime(true) - $this->_start) * 1000);
        $this->write("##teamcity[testSuiteFinished name='kahlan.suite' duration='{$time}']\n");
    }
}