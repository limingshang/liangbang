(function () {
  var d = document;
  var dateopts = {
    beginYear: 2000,
    beginMonth: 1,
    beginDay: 1,
    endYear: new Date ().getFullYear (),
    endMonth: new Date ().getMonth () + 1,
    endDay: new Date ().getDate (),
    format: 'YMD',
  };
  var MdSelectId = '';
  var MdAcceptId = '';
  var dateContentBox = '';
  var datePlugs = '';
  var yearTag = '';
  var monthTag = '';
  var dayTag = '';
  var indexY = 1;
  var indexM = 1;
  var indexD = 1;
  var initM = null;
  var initD = null;
  var yearScroll = null;
  var monthScroll = null;
  var dayScroll = null;
  var Mdate = function (el, opts) {
    if (!opts) {
      opts = {};
    }
    this.id = el;
    this.selectorId = d.getElementById (this.id);
    this.acceptId =
      d.getElementById (opts.acceptId) || d.getElementById (this.id);
    this.beginYear = opts.beginYear || dateopts.beginYear;
    this.beginMonth = opts.beginMonth || dateopts.beginMonth;
    this.beginDay = opts.beginDay || dateopts.beginDay;
    this.endYear = opts.endYear || dateopts.endYear;
    this.endMonth = opts.endMonth || dateopts.endMonth;
    this.endDay = opts.endDay || dateopts.endDay;
    this.format = opts.format || dateopts.format;
    this.dateBoxShow ();
    console.log(this)
  };
  Mdate.prototype = {
    constructor: Mdate,
    dateBoxShow: function () {
      var that = this;
      that.selectorId.onclick = function () {
        that.createDateBox ();
        that.dateSure ();
      };
    },
    reset: function (options) {
      this.beginYear = options.beginYear || this.beginYear;
      this.beginMonth = options.beginMonth || this.beginMonth;
      this.beginDay = options.beginDay || this.beginDay;
      this.endYear = options.endYear || this.endYear;
      this.endMonth = options.endMonth || this.endMonth;
      this.endDay = options.endDay || this.endDay;
      this.createDateBox ();
      this.dateSure ();
    },
    createDateBox: function () {
      var that = this;
      MdatePlugin = d.getElementById ('MdatePlugin');
      if (!MdatePlugin) {
        dateContentBox = d.createElement ('div');
        dateContentBox.id = 'MdatePlugin';
        d.body.appendChild (dateContentBox);
        MdatePlugin = d.getElementById ('MdatePlugin');
      }
      MdatePlugin.setAttribute ('class', 'slideIn');
      that.createDateUi ();
      var yearUl = d.getElementById ('yearUl');
      var monthUl = d.getElementById ('monthUl');
      var dayUl = d.getElementById ('dayUl');
      yearUl.innerHTML = that.createDateYMD ('year');
      that.initScroll ();
      that.refreshScroll ();
    },
    createDateUi: function () {
      var str =
        '' +
        '<section class="getDateBg"></section>' +
        '<section class="getDateBox" id="getDateBox">' +
        '<div class="choiceDateTitle">' +
        '<button id="dateCancel">取消</button>' +
        '<button id="dateSure" class="fr">确定</button>' +
        '</div>' +
        '<div class="dateContent">' +
        '<div class="checkeDate"></div>' +
        '<div id="yearwrapper">' +
        '<ul id="yearUl"></ul>' +
        '</div>' +
        '<div id="monthwrapper">' +
        '<ul id="monthUl"></ul>' +
        '</div>' +
        '<div id="daywrapper">' +
        '<ul id="dayUl"></ul>' +
        '</div>' +
        '</div>' +
        '</section>';
      MdatePlugin.innerHTML = str;
    },
    createDateYMD: function (type) {
      var that = this;
      var str = '<li>&nbsp;</li>';
      var beginNum = null,
        endNum = null,
        unitName = '年',
        dataStyle = 'data-year';
      if (type == 'year') {
        beginNum = that.beginYear;
        endNum = that.endYear;
      }
      if (type == 'month') {
        unitName = '月';
        dataStyle = 'data-month';
        beginNum = that.beginMonth;
        endNum = 12;
        if (yearTag != that.beginYear) {
          beginNum = 1;
        }
        if (yearTag == dateopts.endYear) {
          endNum = that.endMonth;
        }
      }
      if (type == 'day') {
        unitName = '日';
        dataStyle = 'data-day';
        beginNum = 1;
        endNum = new Date (yearTag, monthTag, 0).getDate ();
        if (yearTag == that.beginYear && monthTag == that.beginMonth) {
          beginNum = that.beginDay;
        }
        if (yearTag == that.endYear && monthTag == that.endMonth) {
          endNum = that.endDay;
        }
      }
      for (var i = beginNum; i <= endNum; i++) {
        str +=
          '<li ' +
          dataStyle +
          '=' +
          i +
          '>' +
          that.dateForTen (i) +
          unitName +
          '</li>';
      }
      return str + '<li>&nbsp;</li>';
    },
    initScroll: function () {
      var scrollHeight = $ ('.checkeDate').height ();
      var that = this;
      yearScroll = new iScroll ('yearwrapper', {
        snap: 'li',
        vScrollbar: false,
        onScrollEnd: function () {
          indexY = Math.ceil (this.y / scrollHeight * -1 + 1);
          yearTag = yearUl
            .getElementsByTagName ('li')[indexY]
            .getAttribute ('data-year');
          monthUl.innerHTML = that.createDateYMD ('month');
          monthScroll.refresh ();
          try {
            monthTag = monthUl
              .getElementsByTagName ('li')[indexM]
              .getAttribute ('data-month');
          } catch (err) {
            return true;
          }
          dayUl.innerHTML = that.createDateYMD ('day');
          dayScroll.refresh ();
          try {
            dayTag = dayUl
              .getElementsByTagName ('li')[indexD]
              .getAttribute ('data-day');
          } catch (err) {
            return true;
          }
        },
      });
      monthScroll = new iScroll ('monthwrapper', {
        snap: 'li',
        vScrollbar: false,
        onScrollEnd: function () {
          indexM = Math.ceil (this.y / scrollHeight * -1 + 1);
          if (indexM == 1 && yearTag != that.beginYear) {
            monthTag = 1;
          } else {
            monthTag = monthUl
              .getElementsByTagName ('li')[indexM]
              .getAttribute ('data-month');
          }
          dayUl.innerHTML = that.createDateYMD ('day');
          dayScroll.refresh ();
          try {
            dayTag = dayUl
              .getElementsByTagName ('li')[indexD]
              .getAttribute ('data-day');
          } catch (err) {
            return true;
          }
        },
      });
      dayScroll = new iScroll ('daywrapper', {
        snap: 'li',
        vScrollbar: false,
        onScrollEnd: function () {
          indexD = Math.ceil (this.y / scrollHeight * -1 + 1);
          if (indexD == 1 && monthTag != that.beginMonth) {
            dayTag = 1;
          } else {
            dayTag = dayUl
              .getElementsByTagName ('li')[indexD]
              .getAttribute ('data-day');
          }
        },
      });
      console.log(yearTag, monthTag,dayTag)
    },
    refreshScroll: function () {
      var scrollHeight = $ ('.checkeDate').height ();
      var that = this;
      var inputYear = that.acceptId.getAttribute ('data-year');
      var inputMonth = that.acceptId.getAttribute ('data-month');
      var inputDay = that.acceptId.getAttribute ('data-day');
      inputYear = inputYear || that.beginYear;
      inputMonth = inputMonth || that.beginMonth;
      inputDay = inputDay || that.beginDay;
      initM = that.beginMonth;
      initD = that.beginDay;
      if (inputYear != that.beginYear && initM != 1) {
        initM = 1;
      }
      if (inputMonth != that.beginMonth && initD != 1) {
        initD = 1;
      }
      inputYear -= that.beginYear;
      inputMonth -= initM;
      inputDay -= initD;
      yearScroll.refresh ();
      yearScroll.scrollTo (0, inputYear * scrollHeight, 300, true);
      monthScroll.scrollTo (0, inputMonth * scrollHeight, 300, true);
      dayScroll.scrollTo (0, inputDay * scrollHeight, 300, true);
    },
    dateSure: function () {
      var that = this;
      var sureBtn = d.getElementById ('dateSure');
      var cancelBtn = d.getElementById ('dateCancel');
      sureBtn.onclick = function () {
        if (that.format == 'YMD') {
          that.acceptId.value = yearTag + '年' + monthTag + '月' + dayTag + '日';
        } else {
          that.acceptId.value =
            yearTag +
            that.format +
            that.dateForTen (monthTag) +
            that.format +
            that.dateForTen (dayTag);
        }
        that.acceptId.setAttribute ('data-year', yearTag);
        that.acceptId.setAttribute ('data-month', monthTag);
        that.acceptId.setAttribute ('data-day', dayTag);
        that.dateCancel ();
      };
      cancelBtn.onclick = function () {
        that.dateCancel ();
      };
    },
    dateForTen: function (n) {
      if (n < 10) {
        return '0' + n;
      } else {
        return n;
      }
    },
    dateCancel: function () {
      MdatePlugin.setAttribute ('class', 'slideOut');
      setTimeout (function () {
        MdatePlugin.innerHTML = '';
      }, 400);
    },
  };
  if (typeof exports !== 'undefined') {
    exports.Mdate = Mdate;
  } else {
    window.Mdate = Mdate;
  }
}) ();
