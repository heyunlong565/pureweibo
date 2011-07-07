<?php
?>
<div class="att-topic">
    <div class="hd"><h3>关注的话题<span>(<?php echo count($list['rst']);?>)</span></h3></div>
    <div class="bd" id="subjectCount">
			<?php
			if(count($list['rst'])==0&&V('g:m')=='ta'):
			?>
			他没有关注任何话题
			<?php
			endif;
			?>        
		<ul>
			
			<?php
			foreach($list['rst'] as $row):
			?>
			<li rel="subject:<?php echo $row['subject']?>"><a href="<?php echo URL('search.weibo','k='. urlencode($row['subject']))?>"><?php echo $row['subject']?></a>
			<?php
			if(V('g:m')!='ta'):
			?>
			<span class="close" rel="e:deleteSubject" title="删除">x</span>
			<?php
			endif;
			?>
			</li>
			<?php
			endforeach;
			?>
            
        </ul>
		<?php
		if(V('g:m')!='ta'):
		?>
        <div class="add-topic-btn"><a href="javascript:;" id="addSubject">添加</a></div>
		<?php
		endif;
		?>
    </div>
</div>
