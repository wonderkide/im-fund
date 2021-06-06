<?php

namespace app\components;

use Yii;

class Shell extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'service';
    }

    /**
     * Excute command run process
     * @param $commandJob => Path store shell script for run app ATM  Ex. /app/atm/xx/tg/zz-tg.sh
     * @return
     */
    function psExec($commandJob) {
        $command = $commandJob . ' > /dev/null 2>&1 & echo $!';
        exec($command, $op, $status);
        $pid = (int) $op[0];

        if ($pid != "" && $status == 0) {
            return true;
        }

        return false;
    }

    /**
     * Find process is exists
     * @param $program Ex. sx-tg Or sx-bank-bbl-user
     * @return
     */
    function psExists($program) {
        if (!$program)
            return false;
        exec("ps aux | grep -i $program | grep -v grep | awk '{print $2}'", $output);
        if (count($output) > 0)
            return true;
        else
            return false;
    }

    /**
     * Check process after start - restart program
     * @param $program Ex. sx-tg Or sx-bank-bbl-user
     * @return
     */
    function checkPsAfterStart($program) {
        $i = 0;
        while ($i < 10) {
            if (Shell::psExists($program))
                return true;
            $i++;
            sleep(1);
        }
        return false;
    }

    /**
     * Check process after stop program
     * @param $program Ex. sx-tg Or sx-bank-bbl-user
     * @return
     */
    function checkPsAfterStop($program) {
        $i = 0;
        while ($i < 10) {
            if (!Shell::psExists($program))
                return true;
            $i++;
            sleep(1);
        }
        return false;
    }

    /**
     * Check status systemd after start service
     * @param type $name
     * @return boolean
     */
    function _checkSystemdAfterStartService($name) {
        $i = 0;
        while ($i < 10) {
            exec("systemctl status $name |grep -i running", $output);
            if (count($output) > 0)
                return true;
            $i++;
            sleep(1);
        }
        return false;
    }

    /**
     * Check status systemd after stop service
     * @param type $name
     * @return boolean
     */
    function _checkSystemdAfterStopService($name) {
        $i = 0;
        while ($i < 10) {
            exec("systemctl status $name |grep -i dead", $output);
            if (count($output) > 0)
                return true;
            $i++;
            sleep(1);
        }
        return false;
    }

    /* --------------------- Kill process ----------------------- */

    /**
     * Kill process by PID
     * @param $pid Ex. 1123 Or 8458
     */
    function psKillByPid($pid) {
        if (!$pid)
            return false;

        exec("kill -15 $pid > /dev/null 2>&1", $rs['output'], $rs['status']);
        return $rs;
    }

    function psForceKillByPid($pid) {
        if (!$pid)
            return false;
        exec("kill -9 $pid > /dev/null 2>&1", $rs['output'], $rs['status']);
        return $rs;
    }

    /**
     * Kill process by pattern name of process
     * @param $program Ex. sx-tg Or sx-bank-bbl-user
     */
    function psKillByName($program) {
        if (!$program)
            return false;

        exec("ps aux | grep  -i $program | grep -v grep | awk '{print $2}' | xargs kill -15 > /dev/null 2>&1", $rs['output'], $rs['status']);

        return $rs;
    }

    /**
     * Force kill process by pattern name of process
     * @param $program Ex. sx-tg Or sx-bank-bbl-user
     */
    function psForceKillByName($program) {
        if (!$program)
            return false;

        exec("ps aux | grep  -i $program | grep -v grep | awk '{print $2}' | xargs kill -9 > /dev/null 2>&1", $rs['output'], $rs['status']);

        return $rs;
    }

    /* ---------------------- Get process id ---------------------------- */

    /**
     * Get all pidof process Ex. pidof chrome
     * @param $program
     * @return pid Ex. 17780 17750 15147
     */
    function getAllPidOfProcess($program) {
        if (!$program)
            return false;

        exec("ps aux | grep -i $program | grep -v grep | awk '{print $2}'", $rs['output'], $rs['status']);
        return $rs;
    }

    function getProcessAllInfo($program) {
        exec("ps axo ppid,pid,comm | grep -iw '" . $program . "' | grep -v grep | awk '{print $1,$2}'", $output);
        return $output;
    }

    /* ---------------------- Get resource of machine---------------------------- */

    function getProgCpuUsage($program) {
        if (!$program)
            return false;

        exec("ps aux | grep -i " . $program . " | grep -v grep | grep -v su | awk {'print $3'}", $rs['output'], $rs['status']);
        return $rs;
    }

    function getProgMemUsage($program) {
        if (!$program)
            return false;

        exec("ps aux | grep -i " . $program . " | grep -v grep | grep -v su | awk {'print $4'}", $rs['output'], $rs['status']);
        return $rs;
    }

}
