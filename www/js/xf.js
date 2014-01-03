var XF = window.XF || {};
XF.version = "0.0.1";
XF.author = "chuanwen.chen";

XF.Validate = {
	isChinese: function(str) {
		var _rex = /[u00-uFF]/;
		return !_rex.test(str);
	},
	
	isMobile: function(str) {
		// /^1(3\d{1}|5[389])\d{8}$/  /^((13|15|18|14)+\d{9})$/
		if(/^1[358]\d{9}/.test(str)) {
			return true;
		}
		return false;
	},

	isEmail: function(str) {
		// /^[\w-]+(\.[\w-]+)*@[\w-]+(\.(\w)+)*(\.(\w){2,3})$/
		if(/^[0-9a-z][_.0-9a-z-]{0,31}@([0-9a-z][0-9a-z-]{0,30}\.){1,4}[a-z]{2,4}$/.test(str)) {
			return true;
		}
		return false;
	},

	isNum: function(str) {
		if(/[\d]+/.test(str)) {
			return true;
		}
		return false;
	}

};

XF.Utils = {
	getCurrTime: function() {
		var now = new Date();
		var _month = (10>(now.getMonth()+1))?'0'+(now.getMonth()+1):now.getMonth()+1;
		var _day = (10>now.getDate())?'0'+now.getDate():now.getDate();
		var _hour = (10>now.getHours())?'0'+now.getHours():now.getHours();
		var _minute = (10>now.getMinutes())?'0'+now.getMinutes():now.getMinutes();
		var _second = (10>now.getSeconds())?'0'+now.getSeconds():now.getSeconds();
		return now.getFullYear()+'-'+_month+'-'+_day+' '+_hour+':'+_minute+':'+_second;
	},

	strlen: function(str) {
		var _strlength=0;
		for(i=0; i<str.length; i++) {
			if(XF.Validate.isChinese(str.charAt(i)) == true)
				_strlength = _strlength + 2;
			else
				_strlength = _strlength + 1;
		}
		return _strlength;
	},

	getParameter: function(name) {
		var r = new RegExp("(\\?|#|&)" + name + "=([^&#]*)(&|#|$)");
		var m = location.href.match(r);
		return (!m?"":m[2]);
	},

	getParam: function(param_name) {
		var query = location.search.substring(1);
		var pairs = query.split('&');
		for (var i = 0; i < pairs.length; i++) {
			var pos = pairs[i].indexOf('=');
			if (pos == -1) continue;
			var argname = pairs[i].substring(0, pos);
			if (argname.toLowerCase() == param_name.toLowerCase()) {
				var value = pairs[i].substring(pos + 1);
				value = decodeURIComponent(value);
				return value;
			}
		}
		return null;
	},

	getDomain: function() {
		return location.host.replace(/:\d+/, "");
	},

	getBrowser: function() {
		var g;
		var h = navigator.userAgent.toLowerCase();
		(h.match(/msie ([\d.]+)/)) ? g = "IE": (h.match(/firefox\/([\d.]+)/)) ? g = "Firefox": (h.match(/chrome\/([\d.]+)/)) ? g = "Chrome": (h.match(/opera.([\d.]+)/)) ? g = "Opera": (h.match(/version\/([\d.]+).*safari/)) ? g = "Safari": 0;

		return g;
	},

	//获取字符串长度，一个汉字长度为2
	getStrLen: function(str) {
		return str.replace(/[^\x00-\xff]/g, "rr").length;
	},

	//给String对象添加getBytes方法，以获取实际字节长度(中文算2字节)
	getBytes = function(str) {
		return str.replace(/[^\x00-\xff]/ig, "oo").length;
	},

	//返回指定长度的字符串
	getSubStr: function(str, len) {
		var sLen = XF.Utils.getStrLen(str);
		if(sLen <= len) return str;
		var rgx = /[^\x00-\xff]/,
			resultStr = '',
			tempStr = '',
			k = 0,
			m = 0;
		while(m < len){
			tempStr = str.charAt(k);
			rgx.test(tempStr) ? m += 2 : m++;
			k++;
			resultStr += tempStr;
		}
		return resultStr + '...';
	},

	genSuid: function() {
		var a = new Date().getUTCMilliseconds();
		return (Math.round(Math.random()*2147483647)*a)%10000000000;
	},

	/**
	 * 判断某字符串是否在目标数组中
	 * @param {String}  目标关键字
	 * @param {Array}   目标数组
	 * @param {Boolean}   是否全等(即完全相同)
	 */
	inArray: function(key, arr, same) {
		if(!same) return arr.join(' ').indexOf(key) != -1;
		for(var i=0, l = arr.length; i< l; i++)
			if(arr[i]==key) return true;
		return false;
	},

	trim: function(str) {
		for (var i = 0; i < str.length && str.charAt(i) == " "; i++);
		for (var j = str.length; j > 0 && str.charAt(j - 1) == " "; j--);
		if (i > j) return "";
		return str.substring(i, j);
	},

	//转码
	encodeStr: function(prev, str) {
		var tempStr = '';
		for(var i = 0, strLen = str.length; i < strLen; i++){
			var hexStr = str.charCodeAt(i).toString(16);
			if(hexStr.length <= 2){//按UTF-16进行编码		
				hexStr = '00' + hexStr;
			}
			tempStr += hexStr;
		}
		tempStr = '0x' + tempStr;
		return prev + 'X-CUSTOM' + tempStr;
	},

	htmlEncode: function(str) {
		return str.replace(/&/g, '&amp;').replace(/>/g, '&gt;').replace(/</g, '&lt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
	},

	htmlUnEncode: function(str) {
		return str.replace(/&amp;/g, '&').replace(/&gt;/g, '>').replace(/&lt;/g, '<').replace(/&quot;/g, '"').replace(/&#39;/g, "'");
	}
};

XF.Cookie = {
	set: function(name, value, expires, path, domain) {
		if(typeof expires == "undefined") {
			expires = new Date(new Date().getTime()+24*3600*1000);
		}
		document.cookie = name+"="+escape(value)+((expires)?"; expires="+expires.toGMTString():"")+((path)?"; path="+path:"; path=/")+((domain)?";domain="+domain:"");
	},

	get: function(name) {
		var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
		if(arr!=null){
			return unescape(arr[2]);
		}
		return null;
	},

	clear: function(name, path, domain) {
		if(this.get(name)) {
			document.cookie = name+"="+((path)?"; path="+path:"; path=/")+((domain)?"; domain="+domain:"")+";expires=Fri, 02-Jan-1970 00:00:00 GMT";
		}
	}
};
