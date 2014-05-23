<?php
namespace ay\xhprof;

class callgraph
{
    private $request;
    
    public function __construct($request)
    {
        $this->request	= $request;
    }
    
    /**
     * @param	array	$callstack	The callstack must have UIDs.
     * @param	boolean	$output	TRUE will output the content to the stdout and set the Content-Type to text/plain
     * @param	boolean	$debug	TRUE will output a less complicated DOT script.
     * 
     * @return resource
     */
    public function dot($callstack, $output = FALSE, $debug = FALSE)
    {
        // define min bounds required to be displayed
        // min number of invocations 
        $minCt = 1;
                
        $players	= array();
        $calls		= array();

        $mother		= $callstack[0];

        if(!isset($mother['uid'])) {
            throw new CallgraphException('Invalid callstack input. UIDs are not populated.');
        }

        $group_colors	= array('#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf');
        
        $graphRoot = null;
        if (!empty($_GET['xhprof']['callgraph']['root'])) {
            $graphRoot = $_GET['xhprof']['callgraph']['root'];
        }
        $output = false;
        foreach($callstack as $e) {
            if ($graphRoot) {
                if (preg_match('@'. '_'.  $graphRoot .'(_|$)@', $e['uid']) !== 1) {
                    continue;
                }
            }
            
            $callee_uid	= $e['uid'] . '_' . $e['callee_id'];

            if($e['caller']) {
                $calls[]	= "\t\"" . $e['uid'] . '" -> "' . $callee_uid . '";';
            }

            if(isset($players[$callee_uid])) {
                throw new CallgraphException('Duplicate player is not possible in an exclusive callstack.');
            }

            if($debug) {
                $players[$callee_uid]	= "\t\"" . $callee_uid . '"[shape=square, label="' . $e['callee'] . '"];';
            } else {
                $ct	= '';

                if($e['caller'] && $e['metrics']['ct'] > $minCt) {
                    $ct	= '<tr>
                        <td align="left" width="50">ct</td>
                        <td align="left">' . $e['metrics']['ct'] . '</td>
                    </tr>';
                }

                $column_group_color	= '';

                if(!empty($e['group']) && $e['group']['index'] < 10) {
                    $column_group_color	= ' bgcolor="' . $group_colors[$e['group']['index']-1] . '"';
                }
                
                $class = '';
                $method = $e['callee'];
                if(($pos = strpos($e['callee'], '::')) !== false) {
                    $class = trim(substr($e['callee'], 0, $pos));
                    $method = substr($e['callee'], $pos + 2);
                    
                    // when using eval, callee also contains the filename.
                    // cut it off, to save space
                    if(($pos = strpos($method, ':')) !== false) {
                        $method = trim(substr($method, $pos + 1));
                    }
                }
                
                $href = htmlentities('?xhprof[template]=function&xhprof[query][request_id]='. $this->request['id'] .'&xhprof[query][callee_id]='. $e['callee_id']);

                $players[$callee_uid]	= "\t\"" . $callee_uid . '"[shape=none,href="'. $href .'",target="_blank",tooltip="'. $e['callee'] .'",label=<
                <table border="0" cellspacing="0" cellborder="1" cellpadding="2" CELLSPACING="0">
                    <tr>
                        <td colspan="2" align="left"' . $column_group_color . '>' . $class . '<br />' . $method . '</td>
                    </tr>
                    ' . $ct . '
                    <tr>
                        <td align="left">wt</td>
                        <td align="left" bgcolor="0.000 ' . sprintf('%.3f', $mother['metrics']['wt'] ? $e['metrics']['wt']/$mother['metrics']['wt'] : 0) . ' 1.000">' . format_microseconds($e['metrics']['wt'], false) . '</td>
                    </tr>
                    <tr>
                        <td align="left">cpu</td>
                        <td align="left" bgcolor="0.000 ' . sprintf('%.3f', $mother['metrics']['cpu'] ? $e['metrics']['cpu']/$mother['metrics']['cpu'] : 0) . ' 1.000">' . format_microseconds($e['metrics']['cpu'], false) . '</td>
                    </tr>
                    <tr>
                        <td align="left">mu</td>
                        <td align="left" bgcolor="0.000 ' . sprintf('%.3f', $mother['metrics']['mu'] ? $e['metrics']['mu']/$mother['metrics']['mu'] : 0) . ' 1.000">' . format_bytes($e['metrics']['mu'], 2, false) . '</td>
                    </tr>
                    <tr>
                        <td align="left">pmu</td>
                        <td align="left" bgcolor="0.000 ' . sprintf('%.3f', $mother['metrics']['pmu'] ? $e['metrics']['pmu']/$mother['metrics']['pmu'] : 0) . ' 1.000">' . format_bytes($e['metrics']['pmu'], 2, false) . '</td>
                    </tr>
                </table>
                >];';
            }
        }

        $dot		=
            implode(PHP_EOL, $players) . PHP_EOL . PHP_EOL .
            implode(PHP_EOL, $calls);

        $dot		= "digraph\r{\r{$dot}}";
        

        if(!$output) {
            return $dot;
        }

        header('Content-Type: text/plain');

        echo $dot;

        exit;
    }

    public function graph($dot_script)
    {
        $descriptors	= array
        (
            array('pipe', 'r'),
            array('pipe', 'w'),
            array('pipe', 'w')
        );

        $process		= proc_open('dot -Tsvg', $descriptors, $pipes, BASE_PATH);

        if($process === FALSE) {
            throw new CallgraphException('Failed to initiate DOT process.');
        }

        fwrite($pipes[0], $dot_script);
        fclose($pipes[0]);

        $output			= stream_get_contents($pipes[1]);
        $error			= stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);

        proc_close($process);

        if(!empty($error)) {
            throw new CallgraphException('DOT produced an error:'. $error);
        }

        if(empty($output)) {
            throw new CallgraphException('DOT did not output anything.');
        }

        header('Content-Type: image/svg+xml');
        #header('Content-Type: image/png');
        echo $output;

        exit;
    }
}

class CallgraphException extends \Exception {}
