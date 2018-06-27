var Cookie = {
    set: function (key, val, expireDays) {
        // 判断是否设置expireDays
        if (expireDays) {
            var date = new Date();
            date.setTime(date.getTime() + expireDays * 3600 * 24 * 1000);
            var expireStr = 'expires=' + date.toGMTString() + ';';
        } else {
            var expireStr = '';
        }
        document.cookie = key+'='+encodeURI(val)+';'+expireStr;
    },
    get: function (key) {
        var res = '';
        var data = document.cookie.split('; ');
        for (x in data) {
            var i = data[x].split('=');
            if (i[0] === key) {
                res = i[1];
                break;
            }
        }
        return res;
    },
    empty: function (key) {
        var res = '';
        var data = document.cookie.split('; ');
        for (x in data) {
            var i = data[x].split('=');
            if (i[0] === key) {
                Cookie.set(key, '', -1);
            }
        }
    }
};
