<!--本地关注榜-->
<?php if (!empty($list)) {?>
<div class="top10">
	<div class="hd"><h3><?php echo isset($mod['newTitle'])?$mod['newTitle']:'本地关注榜';?></h3></div>
	<div class="bd">
		<ul>
			<?php
			$i=0;
			
			foreach($list as $key => $row):
			?>
			 <li>
				<div class="ranking r-<?php echo ++$i;?> skin-bg"><?php echo $i;?></div>
				<a href="<?php echo URL('ta','id='.$row['sina_uid'])?>"><?php echo $row['screen_name']?></a>
				<span>(<?php echo $row['followers_count']; ?>)</span>
			</li>
			 <?php
			 endforeach;
			 ?>
		
		</ul>
	</div>
</div>
<?php }?>
