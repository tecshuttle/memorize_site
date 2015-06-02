<pre>
<?php foreach ($days as $day): ?>

<?= $day['date'] ?>

<?php if (count($day['jobs']) === 0): ?>
    无
<?php else: ?>
<?php foreach ($day['jobs'] as $job): ?>
    <?= $job->job_name ?>  <?= ($job->status === '1' ? 'done' : 'planing') ?>  <?= ($job->time_long / 3600) ?>H
<?php endforeach; ?>
<?php endif; ?>
<?php endforeach; ?>


EOF
</pre>