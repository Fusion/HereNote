function heredoc(fn) {
    return fn.toString().split('\n').slice(1,-1).join('\n') + '\n'
}

function ajax_send(data, cb) {
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/ajax/',
        data: data,
        success: function(data) {
            cb(true, data);
        },
        error: function(data) {
            cb(false, data);
        }
    });
}

function inform(title, msg, type, velocity, timeout) {
    if(typeof timeout == "undefined") {
        timeout = 2000;
        if(typeof velocity == "undefined") {
            velocity = 200;
            if(typeof type == "undefined") {
                type = 'success';
            }
        }
    }
    jQuery(this).notifyMe(
        'top',
        type,
        title,
        msg,
        velocity,
        timeout);
}
