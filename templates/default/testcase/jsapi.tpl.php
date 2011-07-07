<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Xwb Request API Test</title>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/xwbrequestapi.js"></script>
</head>
<body id="home">
<script>

function testRequest(){
    // POST
    Xwb.request.post(
        'http://demo.rayli.com.cn/?m=action.getCounts',
        {ids:'3042338323,3042296891'},
        function(e){
            if(e.isOk()){
                console.log("", e.getRaw());
            }
        }
    );
    
    // JSONP
    Xwb.request.q(
        'http://bbs.rayli.com.cn/api/sinax.php',
        {
            action : 'sinalogin',
            name   : 'javeejy',
            pwd    : 'jiangyuan'
        },
        function(e){
            if(e.isOk()){
                console.log(e.getRaw());
            }
        },
        {jsonp:'jscallback'}
    );
}

// testRequest();

function testUserPost(){
    Xwb.request.post("这是我的一条微博信息。", function(e){
        if(e.isOk()){
            console.log('微博发送成功:', e.getData());
        }else console.warn('微博发送失败:'+e.getCode()+':'+e.getMsg());
    });
}

//testUserPost();

function testPostImgText(){
    Xwb.request.postImgText("这是一条图文微博", 1112333, function(e){
        if(e.isOk()){
            console.log('图文微博发送成功:', e.getData());
        }else console.warn('图文微博发送失败:'+e.getCode()+':'+e.getMsg());        
    });
}

// testPostImgText();

function testRepost(){
    Xwb.request.repost('3082135629', '这是ROCK转发的','','', function(e){
        if(e.isOk()){
            console.log('微博转发成功:', e.getData());
        }else console.warn('微博转发失败:'+e.getCode()+':'+e.getMsg());    
    });
}

// testRepost();

function testUserDel(){
    Xwb.request.del(3082592139, function(e){
        if(e.isOk()){
            console.log('删除微博成功:', e.getData());
        }else console.warn('删除微博失败:'+e.getCode()+':'+e.getMsg());          
    });
}

// testUserDel();

function testUserComment(){
    Xwb.request.comment(3082483309, "这是ROCK的评论内容", 1, 1, function(e){
        if(e.isOk()){
            console.log('发表微博评论成功:', e.getData());
        }else console.warn('发表微博评论失败:'+e.getCode()+':'+e.getMsg());
    });
}

// testUserComment();

function testUserDelComment(){
    Xwb.request.delComment(3833917067, function(e){
        if(e.isOk()){
            console.log('删除微博评论成功:', e.getData());
        }else console.warn('删除微博评论失败:'+e.getCode()+':'+e.getMsg());        
    });
}

// testUserDelComment();

function testUserReply(){
    Xwb.request.reply(3833988901, 3082818203, '这是回复内容', 0, 1, function(e){
        if(e.isOk()){
            console.log('回复评论成功:', e.getData());
        }else console.warn('回复评论失败:'+e.getCode()+':'+e.getMsg());          
    });
}

// testUserReply();

function testUserFollow(){
    Xwb.request.follow('rockjav', 1, function(e){
        if(e.isOk()){
            console.log('关注用户'+'rockjav'+'成功:', e.getData());
        }else console.warn('关注用户失败:'+e.getCode()+':'+e.getMsg());
    });
}

// testUserFollow();

function testUserUnfollow(){
    Xwb.request.unfollow('rockjav', 1, function(e){
        if(e.isOk()){
            console.log('取消关注用户'+'rockjav'+'成功:', e.getData());
        }else console.warn('取消关注用户失败:'+e.getCode()+':'+e.getMsg());
    });
}

// testUserUnfollow();

function testUserFav(){
    Xwb.request.fav('3082941523', function(e){
        if(e.isOk()){
            console.log('收藏用户成功:', e.getData());
        }else console.warn('收藏用户失败:'+e.getCode()+':'+e.getMsg());
    });
}

// testUserFav();


function testUserDelFav(){
    Xwb.request.delFav('3082941523', function(e){
        if(e.isOk()){
            console.log('取消收藏用户成功:', e.getData());
        }else console.warn('取消收藏用户失败:'+e.getCode()+':'+e.getMsg());
    });
}

// testUserDelFav();


function testUserSetProfile(){
    Xwb.request.setProfile({description:'你好，这是一个互动测试平台'}, function(e){
        if(e.isOk()){
            console.log('用户信息更新成功:', e.getData());
        }else console.warn('用户信息更新失败:'+e.getCode()+':'+e.getMsg());
    });
}

// testUserSetProfile();

function testUserUnread(){
    Xwb.request.unread(3082483309, function(e){
        if(e.isOk()){
            console.log('获得未读信息成功:', e.getData());
        }else console.warn('获得未读信息失败:'+e.getCode()+':'+e.getMsg());
    });
}

// testUserUnread();

function testUserGetComments(){
    Xwb.request.getComments(3082818203, 1, 1, function(e){
        if(e.isOk()){
            console.log('获得评论列表成功:', e.getData());
        }else console.warn('获得评论列表失败:'+e.getCode()+':'+e.getMsg());
    });
}

// testUserGetComments();

function testUserMsg(){
    Xwb.request.msg('', 'rockjav', '私信内容', function(e){
        if(e.isOk()){
            console.log('私信发送成功:', e.getData());
        }else console.warn('私信发送失败:'+e.getCode()+':'+e.getMsg());
    });
}

// testUserMsg();


function testUserDelMsg(){
    Xwb.request.delMsg(1112333, function(e){
        if(e.isOk()){
            console.log('私信删除成功:', e.getData());
        }else console.warn('私信删除失败:'+e.getCode()+':'+e.getMsg());
    });
}



// testUserDelMsg();

function testUserFollowed(){
    Xwb.request.followed('源irock', '', function(e){
        if(e.isOk()){
            console.log('是否为关注:', e.getData());
        }else console.warn('测试是否为关注失败:'+e.getCode()+':'+e.getMsg());
    }, 1, 1);
}

// testUserFollowed();

function testUserSetting(){
    Xwb.request.setting('tipshow', function(e){
        if(e.isOk()){
            console.log('setting成功:', e.getData());
        }else console.warn('setting失败:'+e.getCode()+':'+e.getMsg());
    });
}

// testUserSetting();

function testUserCounts(){
    Xwb.request.counts('3042338323,3042296891', function(e){
        if(e.isOk()){
            console.log('counts成功:', e.getData());
        }else console.warn('counts失败:'+e.getCode()+':'+e.getMsg());
    });
}

// testUserCounts();

function testPubSinaurl(){
    Xwb.request.sinaurl('h99TFC', function(e){
        if(e.isOk()){
            console.log('sinaurl成功:', e.getData());
        }else console.warn('sinaurl失败:'+e.getCode()+':'+e.getMsg());
    });
}

testPubSinaurl();

</script>
</body>
</html>