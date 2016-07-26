/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $('.bfh-countries').bfhcountries({country: 'US'});

    $('.required input').attr('required', 'required');

    jQuery.validator.addMethod("regex", function (value, element) {
        return this.optional(element) || /^[a-zA-Zа-яА-Я0-9_\.\'\s]+$/.test(value);
    }, "The field can only consist of alphabetical, number, dot, underscore and apostrophe");

    var validator = $('#first-form').validate({
        rules         : {
            firstName    : {
                minlength: 3,
                maxlength: 30,
                required : true,
                regex    : true
            },
            lastName     : {
                minlength: 3,
                maxlength: 30,
                required : true,
                regex    : true
            },
            phone        : {
                minlength: 5
            },
            email        : {
                maxlength: 30
            },
            reportSubject: {
                minlength: 5,
                maxlength: 100,
                required : true,
                regex    : true
            },
            birthday     : {
                minlength: 10
            }
        },
        highlight     : function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight   : function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement  : 'span',
        errorClass    : 'help-block',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $('#first-form').submit(function (e) {
        e.preventDefault();
        if (validator.valid()) {
            $.ajax({
                url    : '/conference/save-first-form',
                data   : $('#first-form').serialize(),
                method : "POST",
                success: function (response) {
                    if ($.isNumeric(response)) {
                        setCookie('userid', response);
                        setVisibleForm(2);
                        return;
                    }

                    var json = jQuery.parseJSON(response);
                    validator.showErrors(json);
                }
            });
        }
    });

    function setVisibleForm(number) {
        for (var i = 1; i < 4; i++) {
            if (i != number) {
                $('.form-' + i).addClass("hidden");
            } else {
                $('.form-' + i).removeClass("hidden");
            }
        }
    }

    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    function setCookie(name, value, options) {
        options = options || {};

        var expires = options.expires;

        if (typeof expires == "number" && expires) {
            var d = new Date();
            d.setTime(d.getTime() + expires * 1000);
            expires = options.expires = d;
        }
        if (expires && expires.toUTCString) {
            options.expires = expires.toUTCString();
        }

        value = encodeURIComponent(value);

        var updatedCookie = name + "=" + value;

        for (var propName in options) {
            updatedCookie += "; " + propName;
            var propValue = options[propName];
            if (propValue !== true) {
                updatedCookie += "=" + propValue;
            }
        }

        document.cookie = updatedCookie;
    }

    function deleteCookie(name) {
        setCookie(name, "", {
            expires: -1
        })
    }

    if (getCookie("userid") != undefined) {
        setVisibleForm(2);
    } else {
        setVisibleForm(1);
    }

    $('.birthday').datetimepicker({
        format        : "yyyy-mm-dd",
        weekStart     : 1,
        todayBtn      : 1,
        autoclose     : 1,
        todayHighlight: 1,
        startView     : 2,
        minView       : 2,
        endDate       : new Date(),
    });

    $('#my-file-selector').change(function () {
        var filename = $(this).val().replace(/^.*\\/, "");
        $('#upload-file-info').html(filename);
    });

    $('#second-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url        : '/conference/save-second-form',
            type       : 'POST',
            data       : new FormData(this),
            processData: false,
            contentType: false,
            success    : function (response) {
                if (response == "Success") {
                    setVisibleForm(3);
                    deleteCookie('userid');
                }

                var json = jQuery.parseJSON(response);
                if (json.photo != undefined) {
                    console.log(json.photo);
                    $('#my-file-selector').closest('.form-group').addClass('has-error');
                    $('.file-error').html(json.photo).css("color", "#a94442");
                }

            }
        });

    });

});
