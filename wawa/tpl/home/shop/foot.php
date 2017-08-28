<div class="weui_tabbar">
        <a id="menu-index-btn" href="index.php" class="weui_tabbar_item  <?php if($lan=='index'){ ?>  weui_bar_item_on <?php } ?>"  >
            <p class="weui_tabbar_label">夹娃娃</p>
        </a>
        <a id="menu-records-btn" href="index.php?action=jilu" class="weui_tabbar_item <?php if($lan=='jilu'){ ?>  weui_bar_item_on <?php } ?> ">
            <p class="weui_tabbar_label">记录</p>
        </a>
        <a id="menu-income-btn" href="index.php?action=yongjin" class="weui_tabbar_item  <?php if($lan=='yongjin'){ ?>  weui_bar_item_on <?php } ?>  ">
            <p class="weui_tabbar_label">佣金</p>
        </a>
        <a id="menu-income_rank-btn" href="index.php?action=paihangbang" class="weui_tabbar_item <?php if($lan=='paihangbang'){ ?>  weui_bar_item_on <?php } ?>" >
            <p class="weui_tabbar_label">排行榜</p>
        </a>
        <a id="menu-qrcode-btn" href="index.php?action=zhuanqian&tuid=<?php  echo  $_SESSION['uid'] ?>" class="weui_tabbar_item  <?php if($lan=='zhuanqian'){ ?>  weui_bar_item_on <?php } ?>">
            <p class="weui_tabbar_label">赚钱</p>
                <span class="tab-num"></span>
        </a>
    </div>