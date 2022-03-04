var ultra = {
    modal: function($link) {
        var href = $link.prop('href');
        var title = $link.data('title');
        $modal = $('<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> <h4 class="modal-title">' + title + '</h4></div><div class="modal-body"></div><div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary save-button">Save changes</button></div></div></div></div>');
        $('body').append($modal);
        $modal.find('.modal-body').load(href);
        $modal.modal()
            .find('.save-button')
            .on('click', function(e) {
                $modal.find('form').trigger('submit');
            });
        $modal.on('hidden.bs.modal', function(e) {
            $modal.remove();
        })
    },
    closeModal: function(form) {
        $('body').find(form).closest('.modal').modal('hide');
    },
    confirm: function(link) {
        bootbox.confirm(link.data('prompt'), function(result) {
            if (result) {
                $.ajax({
                    url: link.attr('href'),
                    data: link.data('d'),
                    type: 'post',
                    dataType: 'json',
                    success: function(response) {
                        var func = window[link.data('func')];
                        if (typeof func == 'function') {
                            func(response, result, link);
                        }
                    }
                });
            }
        });
    },
    msg: function(state, title, msg, duration, redirectUrl) {
        var alert = $('<div class="alert alert-'+state+' alert-dismissible fade show" role="alert"><div class="d-md-flex">\n' +
            '<div class="d-flex">' +
            '<i class="icon icon-'+state+' h1 m-0"></i><div class="mt-1 mx-3 font-weight-bold">'+title+'</div></div>' +
            '<div class="mt-1">'+msg+'</div></div>' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icon icon-close"></i></button>' +
            '</div>').hide();

        $('#ultra-alert').find('.alert').remove();

        if (duration != undefined) {
            if (!duration) {
                $('#ultra-alert').append(alert).find('.alert').slideDown('fast');
            } else {
                $('#ultra-alert').append(alert).find('.alert').slideDown('fast').animate({
                    opacity: 1
                }, duration, function() {
                    $(this).fadeOut('medium', function() {
                        $(this).remove();
                        if(redirectUrl != undefined){
                            window.location.href = redirectUrl;
                        }
                    });
                })
            }
        } else {
            $('#ultra-alert').append(alert).find('.alert').animate({
                opacity: 1
            }, 5000, function() {
                $(this).fadeOut('medium', function() {
                    $(this).remove();
                    if(redirectUrl != undefined){
                        window.location.href = redirectUrl;
                    }
                });
            })
        }
    },
    lockform: function(data, form, opts) {
        form.find(':submit').addClass('loading').attr('disabled', true);
        form.find(':input').addClass('loading').attr('disabled', true);
    },
    unlockform: function($form) {
        $($form).find(':submit').removeClass('loading').attr('disabled', false);
        $($form).find(':input').addClass('loading').attr('disabled', false);
    }
};