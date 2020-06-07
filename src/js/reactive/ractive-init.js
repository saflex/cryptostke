var _path_view = 'src/view';

var ractiveComponent = {};


var requireElement = function (param) {

    var name, _ver, el_selector, data;
    if ('string' == typeof param) {
        throw new Error('[Ractive 001]: You have to specify a typeof param Ractive.requireElement');
    } else {
        name = param.name;
        _ver = param.ver || '1.0.0';
        el_selector = param.el_selector;
        data = param.data || {};
        data._e = _e;

    }

    if (!name) {
        throw new Error('[Ractive 002]: You have to specify a file/name Ractive.requireElement');
    }
    if (!Ractive.components[name]) {
        Ractive.require(_path_view + '/' + name + '/style.css?ver=' + _ver);
        Ractive.getHtml(_path_view + '/' + name + '/index.html?ver=' + _ver).then(function (template) {
            ractiveComponent[name] = new Ractive({
                el: el_selector,
                template: template,
                data: data,
                oninit: function () {
                    console.log(name + ' init!');
                },
                oncomplete: function () {
                    Ractive.require(_path_view + '/' + name + '/script.js?ver=' + _ver).then(function () {
                        Ractive.components['_'+name] = window[name+'_cls'].extend({
                            template: template
                        });
                        ractiveComponent['_'+name] = new window[name+'_cls']();

                    });
                }
            });
        });
    }

};
Ractive.DEBUG_PROMISES = false;
window['requireElement'] = requireElement;

