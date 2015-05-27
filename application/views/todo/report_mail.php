<?php foreach ($days as $day): ?>
    <h2><?= $day['date'] ?></h2>

    <div style="margin-left: 2em;">
        <?php if (count($day['jobs']) === 0): ?>
            <p>无</p>
        <?php else: ?>
            <?php foreach ($day['jobs'] as $job): ?>
                <p style="color:<?= ($job->status === '1' ? 'gray' : '#00bb00') ?>;">
                    <?= $job->job_name ?><span style="margin-left: 2em;"><?= ($job->time_long / 3600) ?>H<span>
                </p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>