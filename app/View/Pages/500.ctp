<h1>500 Internal server error</h1>
<p><?php echo $message;?></p>
<?php if ($debug) { ?>
<h2>Detail:</h2>
<div>
    <?php while ($e) { ?>
        <p>Info: <?php echo $e->getMessage(); ?></p>
        <p>At <?php echo $e->getFile() . ': ' . $e->getLine(); ?></p>
        <p>Trace:</p>
        <div>
            <?php for ($i = 0; $i < count($e->getTrace()); ++$i) { ?>
            <?php $trace = $e->getTrace()[$i]; ?>
            <p><?php
                echo ($i + 1) . '&#41; ';
                echo $trace['file'] . '&#40;' . $trace['line'] . '&#41;: ';
                if (array_key_exists('class', $trace))
                    echo $trace['class'] . '::';
                if (array_key_exists('function', $trace))
                    echo $trace['function'] . '&#40;&#41;'
            ?></p>
            <?php } ?>
        </div>
    <?php $e = $e->getPrevious(); } ?>
</div>
<?php } ?>
