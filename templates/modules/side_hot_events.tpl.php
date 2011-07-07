<div class="recent-event">
    <div class="hd">
        <a href="<?php echo URL('event');?>">更多&gt;&gt;</a>
        <h3>热门活动</h3>
    </div>
	<?php TPL::module('side_events', array('events' => $events));?>
</div>
