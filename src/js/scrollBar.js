'use strict';
function createScroll(settionScroll) {
    var keys = [];
    for (var key in settionScroll)
        keys.push(key);
    keys.forEach(function (el) {
        createSctollOne(settionScroll[el]).then(function(res) {
            window[el] = res;
        }, function (err) {
            console.error('Error create scrollBar: ', settionScroll[el], ', error:', err);
        });
    })
}

function createSctollOne(param) {
    return new Promise(function (resolve, reject) {
        var defaultOptionsScroll = {
            axis: "y",
            theme: "dark",
            // setHeight: 'auto',
            callbacks: {
                onCreate: function () {
                    var obj = this;
                    resolve({
                        selector: param.selector,
                        dom_element: obj,
                        dom_content: obj.querySelector('.mCSB_container'),
                        element: $(obj),
                        content: $(obj.querySelector('.mCSB_container'))
                    });
                    param.callbacks.create && param.callbacks.create(null,true);
                    console.log('mCustomScrollbar: [onCreate] $("' + param.selector + '")');
                },
                onInit: function () {
                    param.callbacks.init && param.callbacks.init(null,true);
                    console.log('mCustomScrollbar: [onInit] $("' + param.selector + '")');
                }
            }
        };
        for (var keyOpt in param.options) {
            if (param.options.hasOwnProperty(keyOpt)) {
                defaultOptionsScroll[keyOpt] = param.options[keyOpt];
            }
        }
        $(param.selector).mCustomScrollbar(defaultOptionsScroll);
        setTimeout(function () {
            reject("Timeout Create createSctollOne mCSB_container");
        }, 2000);
    });

}