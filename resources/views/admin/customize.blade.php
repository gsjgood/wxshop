<script src="{{url('js/jquery-3.2.1.min.js')}}"></script>
<!-- <script src="{{url('layui/layui.js')}}"></script> -->

<title>自定义菜单</title>
<!-- 自定义样式 -->
<link rel="stylesheet" href="{{url('./css/wx-custom.css')}}">
</head>

<body>
  <div class="container">
    <div class="custom-menu-edit-con">
      <div class="hbox">
        <div class="inner-left">
          <div class="custom-menu-view-con">
            <div class="custom-menu-view">
              <div class="custom-menu-view__title">Zeus-菜单展示</div>
              <div class="custom-menu-view__body">
                <div class="weixin-msg-list">
                  <ul class="msg-con"></ul>
                </div>
              </div>
              <div id="menuMain" class="custom-menu-view__footer">
                <div class="custom-menu-view__footer__left"></div>
                <div class="custom-menu-view__footer__right"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- 右侧信息填写 -->
        <div class="inner-right">
          <!-- 代码块 -->

        </div>
      </div>
    </div>
    <div class="cm-edit-footer">
      <button id="saveBtns" type="button" class="btn btn-info1">保存</button>
    </div>
  </div>

<!-- 自定义菜单排序 -->
<script>
  // var obj = {
  //   "menu": {
  //     "button": [{
  //       "type": "click",
  //       "name": "今日歌曲",
  //       "key": "你好",
  //       "sub_button": []
  //     }, {
  //       "name": "菜单2",
  //       "sub_button": [{
  //         "type": "view",
  //         "name": "搜索",
  //         "url": "http:\/\/www.soso.com\/",
  //         "sub_button": []
  //       }, {
  //         "type": "miniprogram",
  //         "name": "test",
  //         "url": "http:\/\/mp.weixin.qq.com",
  //         "sub_button": [],
  //         "appid": "wx286b93c14bbf93aa",
  //         "pagepath": "pages\/lunar\/index"
  //       }]
  //     }, {
  //       "name": "菜单3",
  //       "sub_button": [{
  //         "type": "view",
  //         "name": "百度",
  //         "url": "http:\/\/www.baidu.com\/",
  //         "sub_button": []
  //       }]
  //     }]
  //   }
  // };
  var obj = {!!$data!!}; //由控制器传过来
  //显示自定义按钮组
  var button = obj.menu.button; //一级菜单[]
  var menu = '<div class="custom-menu-view__menu"><div class="text-ellipsis"></div></div>'; //显示小键盘
  var customBtns = $('.custom-menu-view__footer__right'); //显示菜单
  showMenu();
  //显示第一级菜单
  function showMenu() {
    if (button.length == 1) {
      appendMenu(button.length);
      showBtn();
      $('.custom-menu-view__menu').css({
        width: '50%',
      });
    }
    if (button.length == 2) {
      appendMenu(button.length);
      showBtn();
      $('.custom-menu-view__menu').css({
        width: '33.3333%',
      });
    }
    if (button.length == 3) {
      appendMenu(button.length);
      showBtn();
      $('.custom-menu-view__menu').css({
        width: '33.3333%',
      });
    }
  }
  //显示子菜单
  function showBtn() {
    for (var i = 0; i < button.length; i++) {
      var text = button[i].name;
      var list = document.createElement('ul');
      list.className = "custom-menu-view__menu__sub";
      $('.custom-menu-view__menu')[i].childNodes[0].innerHTML = text;
      $('.custom-menu-view__menu')[i].appendChild(list);
      for (var j = 0; j < button[i].sub_button.length; j++) {
        var text = button[i].sub_button[j].name;
        var li = document.createElement("li");
        var tt = document.createTextNode(text);
        var div = document.createElement('div');
        li.id = 'sub_' + i + '_' + j; //设置二级菜单id
        div.appendChild(tt);
        li.appendChild(div);
        $('.custom-menu-view__menu__sub')[i].appendChild(li);
      }
    }
  }
  //显示添加的菜单
  function appendMenu(num) {
    var menuDiv = document.createElement('div');
    var mDiv = document.createElement('div');
    var mi = document.createElement('i');
    mDiv.appendChild(mi);
    menuDiv.appendChild(mDiv)
    switch (num) {
      case 1:
        customBtns.append(menu);
        customBtns.append(menuDiv);
        break;
      case 2:
        customBtns.append(menu);
        customBtns.append(menu);
        customBtns.append(menuDiv);
        break;
      case 3:
        customBtns.append(menu);
        customBtns.append(menu);
        customBtns.append(menu);
        break;
    }
  }
</script>