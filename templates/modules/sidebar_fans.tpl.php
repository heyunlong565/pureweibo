					<!-- fans -->
                    <div class="user-sidebar">
                    <div class="sidebar-head"><?php echo F('escape', $userinfo['screen_name']);?>粉丝（<?php echo $userinfo['followers_count'];?>）</div>
                        <ul>
                            <?php if ($followers):?>
                            <?php foreach ($followers as $item):?>
                            <li>
                                <a href="<?php  echo URL('ta',array('id' => $item['id']));?>"><img src="<?php echo APP::F('profile_image_url', $item['profile_image_url']);?>" alt="<?php echo htmlspecialchars($item['screen_name']);?>" /></a>
                                <p><a href="<?php echo URL('ta',array('id' => $item['id']));?>"><?php echo F('escape', $item['screen_name']);?></a></p>
                            </li>
                            <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                        <?php if ($userinfo['followers_count'] > 9):?>
                            <a href="<?php echo URL('ta.fans', 'id='.$userinfo['id']);?>" class="more-user">更多</a>
                        <?php endif;?>
                    </div>
                    <!-- end fans -->
