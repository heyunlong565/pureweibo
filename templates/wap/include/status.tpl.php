	<div>
		<div><span>把新鲜事告诉大家</span></div>
		<form method="post" action="<?php echo WAP_URL('wbcom.postWB'); ?>">
			<div>
                            <?php
                            //var_dump($content);
                            ?>
				<textarea rows="2" name="content">对 @<?php echo $content; ?> 说：</textarea>
			</div>
			<div>
				<input type="submit" value=" 发布 " />
			</div>
		</form>
	</div>