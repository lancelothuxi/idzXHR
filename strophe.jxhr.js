/* jXHR plugin
** by Gueron Jonathan (http://www.iadvize.com)
** This plugin implements cross-domain XmlHttpRequests via jsonp (dynamic script tag hack)
** using a simple json proxy wrapper (PHP)
** licensed under the MIT license
** jXHR.js should be loaded before this plugin.
*/
Strophe.addConnectionPlugin('jxhr', {
    init: function (s) {
        // replace Strophe.Request._newXHR with new jXHR version
        // if jXHR is detected
        if (jXHR) {
            Strophe.Request.prototype._newXHR = function () {
                var xhr = new jXHR();
                //xhr.onerror = function (msg,url) { alert (msg); };
                xhr.onreadystatechange = this.func.prependArg(this);

                return xhr;
            };
        } else {
            Strophe.error("jXHR plugin loaded, but jXHR not found." +
                          "  Falling back to native XHR implementation.");
        }
    }
});
