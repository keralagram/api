<?php

function _getServerLoadLinuxData() {

    if (is_readable("/proc/stat")) {

        $stats = @file_get_contents("/proc/stat");

        if ($stats !== false) {

            $stats = preg_replace("/[[:blank:]]+/", " ", $stats);

            $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);

            $stats = explode("\n", $stats);

            foreach ($stats as $statLine) {

                $statLineData = explode(" ", trim($statLine));

                if((count($statLineData) >= 5) && ($statLineData[0] == "cpu")) {

                    return array(

                        $statLineData[1],

                        $statLineData[2],

                        $statLineData[3],

                        $statLineData[4],

                    );

                }

            }

        }

    }

    return null;

}

function getServerLoad() {

    $load = null;

    if (stristr(PHP_OS, "win")) {

        $cmd = "wmic cpu get loadpercentage /all";

        @exec($cmd, $output);

        if ($output) {

            foreach ($output as $line) {

                if ($line && preg_match("/^[0-9]+\$/", $line)) {

                    $load = $line;

                    break;

                }

            }

        }

    } else {

        if (is_readable("/proc/stat")) {

            $statData1 = _getServerLoadLinuxData();

            sleep(1);

            $statData2 = _getServerLoadLinuxData();

            if((!is_null($statData1)) && (!is_null($statData2))) {

                $statData2[0] -= $statData1[0];

                $statData2[1] -= $statData1[1];

                $statData2[2] -= $statData1[2];

                $statData2[3] -= $statData1[3];

                $cpuTime = $statData2[0] + $statData2[1] + $statData2[2] + $statData2[3];

                $load = 100 - ($statData2[3] * 100 / $cpuTime);

            }

        }

    }

    return $load;

}

$cpuLoad = getServerLoad();

if (is_null($cpuLoad)) {

    echo "CPU load not estimateable (maybe too old Windows or missing rights at Linux or Windows)";

} else {

    if($cpuLoad < 2) {

        $cpuLoad = 0;

    }

    $total = strlen($cpuLoad);

    if($total > 5){

        $cpuLoad = 0;

    }

    echo $cpuLoad . "%";

}

?>