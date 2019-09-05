var demo = new Vue ({
  el: '#app',
  mounted: function () {
    (this.id = this.getUrlPara ('id')), (this.urlParam = {
      firstTab: this.getUrlPara ('firstTab'),
    }), (Vue.http.options.emulateJSON = !0), (Vue.http.options.headers = {
      'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
    }), (this.mobile = sessionStorage.getItem ('flag')), this.mobile
      ? this.getBuyPermission ()
      : (this.hasLogin = !1), this.getChart (), this.getFocusStatus (), this.getDate (), document.addEventListener (
      'touchstart',
      this.touchstart
    ), document.addEventListener (
      'touchend',
      this.touchend
    ), (window.albumInfo = this.albumInfo);
  },
  data: {
    mobile: '',
    ajaxUrl: 'https://tdcl.wkzq.com.cn/',
    id: '',
    urlParam: {firstTab: 0},
    level: '',
    dateSelectorOne: document.getElementById ('dateSelectorOne'),
    dateSelectorTwo: document.getElementById ('dateSelectorTwo'),
    viewData: {
      ID: 'a2decded-17db-4e61-81a5-821a5053d37d',
      strategy_name: '',
      profit_ratio_monthly: 0,
      real_ratio: 0,
      hold_secu_num: 0,
      daily_ratio: 0,
      annualized_ratio: 0,
      annualized_volatility: 0,
      run_num: '-',
      net_value_date: '-',
      net_value: '-',
      sharpe_ratio: '-',
      strategy_describe: '',
      sub_index_value: '-',
      max_drawdown: '-',
    },
    confirmData: {},
    list: [],
    dateList: [],
    periods_date: '',
    startDate: '',
    endDate: '',
    startDateFun: '',
    endDateFun: '',
    focusStatus: 1,
    checked: !1,
    hasLogin: !1,
    hasBuyPermission: 0,
    loginModalFlag: !1,
    bjFlag: !1,
    modalFlag: !1,
    modalMsg: {title: '', body: ''},
    tipsModalFlag: !1,
    dateModalFlag: !1,
    orderModalFlag: !1,
    serviceModalFlag: !1,
    step: 1,
    isCreate: !0,
  },
  methods: {
    loadScript: function (t, e) {
      var a = document.createElement ('script');
      (a.type = 'text/javascript'), a.readyState
        ? (a.onreadystatechange = function () {
            ('complete' != a.readyState && 'loaded' != a.readyState) ||
              (e && e ());
          })
        : (a.onload = function () {
            e && e ();
          }), (a.src = t), document.head.appendChild (a);
    },
    getUrlPara: function (t) {
      var e = new RegExp ('(^|&)' + t + '=([^&]*)(&|$)', 'i'),
        a = window.location.search.substr (1).match (e);
      return null != a ? a[2] : null;
    },
    goBack: function () {
      window.location.href = 'index.html?firstTab=' + this.urlParam.firstTab;
    },
    checkUserConfirm: function () {
      this.$http
        .post (this.ajaxUrl + 'api/strategy/getUserConfirm', {
          fund_code: sessionStorage.getItem (sessionStorage.getItem ('flag')),
        })
        .then (function (t) {
          (this.confirmData =
            t.data.result), void 0 === this.confirmData.confirm_status && (this.confirmData.confirm_status = 1), this.getLevel ();
        });
    },
    getLevel: function () {
      this.$http
        .get (
          'https://wx.wkzq.com.cn/yxfw/base-service/tradeBase/queryFxcsnl?zjzh=' +
            sessionStorage.getItem (sessionStorage.getItem ('flag'))
        )
        .then (function (t) {
          var e = t.data.data;
          (this.level = e.length
            ? parseInt (t.data.data[0].kz_fxcsnl)
            : 0), this.getStrategyHoldList ();
        });
    },
    albumInfo: function (t, e) {
      t &&
        (sessionStorage.setItem (e, t), sessionStorage.getItem ('flag') ||
          (sessionStorage.setItem (
            'flag',
            e
          ), (this.mobile = e)), this.closeModal (), this.getBuyPermission (), sessionStorage.setItem (
          'count',
          sessionStorage.getItem ('count')
            ? String (parseInt (sessionStorage.getItem ('count')) + 1)
            : '1'
        ));
    },
    showServiceModal: function () {
      (this.step = 1), (this.serviceModalFlag = !0), (this.bjFlag = !0);
    },
    getOrder: function () {
      this.mobile
        ? this.hasBuyPermission
            ? this.hasLogin
                ? this.confirmData &&
                    0 === parseInt (this.confirmData.confirm_status)
                    ? 0 === this.viewData.review_status
                        ? this.showOperationModal ()
                        : ((this.modalMsg = {
                            title: '温馨提示',
                            body: '当前策略尚未公布最新一期调仓，请于调仓日9：00进行查看',
                          }), this.showModal ())
                    : 4 <= this.level
                        ? ((this.isCreate = !1), this.showServiceModal ())
                        : ((this.modalMsg = {
                            title: '温馨提示',
                            body: '该产品分险等级高于您的风险承受能力，根据我司适当性规定，您当前不适宜使用此功能',
                          }), this.showModal ())
                : window.egos.tztQKLogin ()
            : ((this.modalMsg = {
                title: '温馨提示',
                body: '您暂未拥有相关权限，请致电客服(40018-40028) 或联系您的客户经理，进行咨询。',
              }), this.showModal ())
        : window.egos.tztQKLogin ();
    },
    sureGoOrder: function (t) {
      var e = this.ajaxUrl + 'home/strategy/getUserAdjustList';
      this.$http
        .post (e, {strategy_id: this.id, oper_type: t})
        .then (function (t) {
          for (
            var e = t.data.result.adjustInfo, a = [], s = 0;
            s < e.length;
            s++
          ) a.push ({stockcode: e[s].secu_code, stockname: e[s].secu_name, count: e[s].adjust_num, mmfx: e[s].trade_direction});
          window.location.href =
            'http://action:10090?url=http://action:10061/?url=/trade/trade_jqwttd.html?info=' +
            JSON.stringify (a) +
            '&&secondtype=9&&fullscreen=1';
        });
    },
    getBuyPermission: function () {
      this.$http
        .post ('https://api.wquant.com/API4/Grit/getOrderInfo.ashx', {
          phone_num: sessionStorage.getItem ('flag'),
          strategy_id: this.id,
          broker_id: 'WKPDN',
        })
        .then (function (t) {
          var e = t.data.result;
          e.hasOwnProperty ('order_info')
            ? ((this.hasBuyPermission = e.order_info[0].order_status), this
                .hasBuyPermission &&
                sessionStorage.getItem (this.mobile) &&
                ((this.hasLogin = !0), this.checkUserConfirm ()))
            : (this.hasBuyPermission = 0);
        });
    },
    getStrategyHoldList: function () {
      this.hasBuyPermission &&
        this.hasLogin &&
        4 <= this.level &&
        (0 === parseInt (this.confirmData.confirm_status)
          ? this.$http
              .post (this.ajaxUrl + 'home/strategy/getStrategyHoldList', {
                strategy_id: this.id,
              })
              .then (function (t) {
                var e = t.data.result.adjust_info[0],
                  a = String (e.periods_date),
                  s = a.slice (0, 4),
                  i = a.slice (4, 6),
                  o = a.slice (6, 8);
                (this.periods_date =
                  s + '-' + i + '-' + o), (this.list = e.adjust_secu);
              })
          : ((this.isCreate = !0), this.showServiceModal ()));
    },
    getChartList: function () {
      this.$http
        .post (this.ajaxUrl + 'home/strategy/getStrategyNetValue', {
          strategy_id: this.id,
        })
        .then (function (t) {
          var e = t.data.result.value_info, r = [], h = [];
          e.forEach (function (t, e) {
            var a = String (t.trading_date),
              s = a.slice (0, 4),
              i = a.slice (4, 6),
              o = a.slice (6, 8),
              n = new Date (s + '-' + i + '-' + o).getTime ();
            r.push ([n, t.net_value]), h.push ([n, t.index_value]);
          }), (window.chartData = {
            PortfolioNAV: r,
            BenchmarkNAV: h,
            text1: this.viewData.strategy_name,
            text2: this.viewData.sub_index,
          }), this.loadScript ('./js/stock1.js');
        });
    },
    getChart: function () {
      this.$http
        .post (this.ajaxUrl + 'home/strategy/getStrategyInfo', {
          strategy_id: this.id,
        })
        .then (function (t) {
          (this.viewData = Object.assign (
            this.viewData,
            t.data.result
          )), (document.title = this.viewData.strategy_name), this.getChartList ();
        });
    },
    getFocusStatus: function () {
      this.$http
        .post (this.ajaxUrl + 'home/strategy/getFocusStatus', {
          phone_num: sessionStorage.getItem ('flag'),
          strategy_id: this.id,
        })
        .then (function (t) {
          var e = t.data.result;
          (this.focusStatus = null == e || '' === e
            ? 1
            : e.focus_status), (this.checked = 0 === this.focusStatus);
        });
    },
    changeFocusStatus: function () {
      var t = new Date (), e = t.getMonth () + 1, a = t.getDate ();
      (a = 10 < a ? a : '0' + a), (e = 10 < e ? e : '0' + e);
      var s = t.getFullYear () + '' + e + a;
      this.$http
        .post (this.ajaxUrl + 'home/strategy/updateFocusStatus', {
          phone_num: sessionStorage.getItem ('flag'),
          strategy_id: this.id,
          focus_status: this.focusStatus ? 0 : 1,
          focus_date: s,
        })
        .then (function () {
          this.getFocusStatus ();
        });
    },
    GetPreMonthDay: function (t, e) {
      var a = t.split ('-'),
        s = a[0],
        i = a[1],
        o = a[2],
        n = new Date (s, i, 0);
      n = n.getDate ();
      var r = s, h = parseInt (i) - e;
      h <= 0 &&
        ((r =
          parseInt (r) - parseInt (h / 12 == 0 ? 1 : parseInt (h) / 12)), (h =
          12 - Math.abs (h) % 12));
      var d = o, l = new Date (r, h, 0);
      return (l = l.getDate ()) < d && (d = l), r + '-' + h + '-' + d;
    },
    showDateModal: function () {
      (this.dateModalFlag = !0), (this.bjFlag = !0), setTimeout (
        function () {
          this.initDate ();
        }.bind (this),
        150
      );
    },
    initDate: function () {
      var t = new Date (),
        e = t.getFullYear (),
        a = t.getMonth () + 1,
        s = t.getDate ();
      (this.endDate =
        e + '-' + a + '-' + s), (this.startDate = this.GetPreMonthDay (
        this.endDate,
        3
      ));
      var i = this.startDate.split ('-');
      $ ('#dateSelectorOne')
        .attr ({'data-year': i[0], 'data-month': i[1], 'data-day': i[2]})
        .val (this.startDate), $ ('#dateSelectorTwo')
        .attr ({'data-year': e, 'data-month': a, 'data-day': s})
        .val (
          this.endDate
        ), (this.startDateFun = new Mdate ('dateSelectorOne', {
        acceptId: 'dateSelectorOne',
        beginYear: i[0],
        beginMonth: i[1],
        beginDay: i[2],
        endYear: e,
        endMonth: a,
        endDay: s,
        format: '-',
      })), (this.endDateFun = new Mdate ('dateSelectorTwo', {
        acceptId: 'dateSelectorTwo',
        beginYear: '2010',
        beginMonth: '',
        beginDay: '',
        endYear: e,
        endMonth: a,
        endDay: s,
        format: '-',
      }));
    },
    selectEndDate: function () {
      this.endDateFun.reset ({
        beginYear: $ ('#dateSelectorOne').attr ('data-year'),
        beginMonth: parseInt ($ ('#dateSelectorOne').attr ('data-month')),
        beginDay: parseInt ($ ('#dateSelectorOne').attr ('data-day')),
      });
    },
    goStep: function (t) {
      this.step = t;
    },
    closeModal: function () {
      (this.isCreate = !0), (this.modalFlag = !1), (this.orderModalFlag = !1), (this.tipsModalFlag = !1), (this.loginModalFlag = !1), (this.dateModalFlag = !1), (this.serviceModalFlag = !1), (this.bjFlag = !1);
    },
    showLoginModal: function () {
      (this.loginModalFlag = !0), (this.bjFlag = !0);
    },
    showTips: function () {
      (this.tipsModalFlag = !0), (this.bjFlag = !0);
    },
    showModal: function () {
      (this.modalFlag = !0), (this.bjFlag = !0);
    },
    getDate: function () {
      this.$http
        .post (this.ajaxUrl + 'home/strategy/getAdjustDate', {
          strategy_id: this.id,
        })
        .then (function (t) {
          this.dateList = t.data.result;
        });
    },
    login: function () {
      window.egos.tztQKLogin ();
    },
    goRnjj: function () {
      (this.modalMsg = {title: '温馨提示', body: '准备中，敬请期待！'}), this.showModal ();
    },
    getTime: function () {
      var t = new Date (), e = t.getFullYear (), a = t.getMonth () + 1;
      a = a < 10 ? '0' + a : a;
      var s = t.getDate ();
      return (
        e +
        '-' +
        a +
        '-' +
        (s = s < 10 ? '0' + s : s) +
        ' ' +
        t.getHours () +
        ':' +
        t.getMinutes () +
        ':' +
        t.getSeconds ()
      );
    },
    showOperationModal: function () {
      (this.orderModalFlag = !0), (this.bjFlag = !0);
    },
    createService: function () {
      this.$http
        .post (this.ajaxUrl + 'api/strategy/saveUserConfirm', {
          fund_code: sessionStorage.getItem (sessionStorage.getItem ('flag')),
          risk_level: this.level,
          confirm_status: 0,
          updatetime: this.confirmData.updatetime
            ? this.confirmData.updatetime
            : this.getTime (),
        })
        .then (function (t) {
          200 === t.data.code &&
            (this.checkUserConfirm (), (this.serviceModalFlag = !1), (this.bjFlag = !1), this
              .isCreate || this.showOperationModal ());
        });
    },
    filterDate: function (t) {
      return (
        (t = t.split ('-'))[0] +
        '' +
        (parseInt (t[1]) < 10 ? '0' + parseInt (t[1]) : t[1]) +
        (parseInt (t[2]) < 10 ? '0' + parseInt (t[2]) : t[2])
      );
    },
    goHistory: function () {
      var t = this.filterDate (
        document.getElementById ('dateSelectorOne').value
      ),
        e = this.filterDate (document.getElementById ('dateSelectorTwo').value);
      window.location.href =
        '../history.html?id=' + this.id + '&&startDate=' + t + '&&endDate=' + e;
    },
    subscribe: function () {
      try {
        this.isAndroid ()
          ? tianDing.ShowDialog ()
          : window.webkit.messageHandlers.IOSMethod.postMessage ('goSubscribe');
      } catch (t) {
        console.log ('无法获取webview');
      }
    },
    touchstart: function (t) {
      1 < t.touches.length && t.preventDefault ();
    },
    touchend: function () {
      var t = new Date ().getTime ();
      t - this.lastTouchEnd <= 300 &&
        event.preventDefault (), (this.lastTouchEnd = t);
    },
    isAndroid: function () {
      var t = navigator.userAgent,
        e = (navigator.appVersion, -1 < t.indexOf ('Android') ||
          -1 < t.indexOf ('Linux'));
      t.match (/\(i[^;]+;( U;)? CPU.+Mac OS X/);
      return !0 == e;
    },
  },
});
