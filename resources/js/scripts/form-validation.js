var FormValidation = function() {

    var initForm = function(options, customCallback) {
        options = $.extend(true, {
            'form': "#form",
            'message': {},
            'rules': {},
            'data': {},
        }, options);

        var form = $(options.form);
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);

        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: options.message,
            rules: options.rules,

            invalidHandler: function(event, validator) { //display error alert on form submit
                success.hide();
                error.show();

                let input = ['input', 'textarea'];
                let current_element = validator.errorList["0"].element;
                let tag = $(current_element).prop("tagName").toLowerCase();

                if (input.indexOf(tag) > -1) {
                    current_element.focus();
                }

                App.scrollTo(error, -200);
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function(element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function(form) {
                success.show();
                error.hide();

                App.blockUI({
                    target: options.form,
                    animate: true
                });

                var optionsAjax = {
                    data: options.data,
                    dataType: 'json',
                    success: typeof customCallback !== "undefined" ? customCallback : callback_form, // Callback jika form success
                    error: callback_error // Callback jika form error
                };

                $(form).ajaxSubmit(optionsAjax);
            }
        });

        function callback_error(xhr, statusText, thrown) {
            App.alert({
                container: $('.alert-container', form),
                place: 'append',
                type: 'danger',
                message: 'Something Wrong, Check Code,',
                // close: true,
                reset: true,
                focus: true,
                // closeInSeconds: 5,
                icon: 'fa fa-warning'
            });

            App.unblockUI(options.form);
        }
    }

    return {
        //main function to initiate the module
        initDefault: function(options, table, customCallback) {
            customCallback = typeof customCallback !== "undefined" ? customCallback : callback_form;
            initForm(options, customCallback);

            var form = $(options.form);
            var error = $('.alert-danger', form);

            function callback_form(res, statusText, xhr, form) // Callback form success
            {
                if (res.status == 1) { // Jika respond status bernilai benar
                    error.hide(); // Hilangkan Label Warning

                    App.alert({
                        container: $('.alert-container', form),
                        place: 'append',
                        type: 'success',
                        message: res.message,
                        close: true,
                        reset: true,
                        focus: true,
                        closeInSeconds: 1.5,
                        icon: 'fa fa-check'
                    });

                    if (res.toastr) {
                        toastr.success(res.toastr);
                    }

                    if (res.modal == 'close') {
                        setTimeout(function() {
                            $('#modal').modal('hide');
                        }, 1500);
                    } else {
                        if(! $(form).hasClass('no-reset-on-submit')){
                            form.resetForm();
                        }
                    }
                    if (res.reset == 'reset') {
                        window.location.reload();
                    }

                    if ($('#reload', form).length) // Jika ada input reload
                    {
                        $('#reload', form).trigger('click'); // Reload
                    }

                    if(! $(form).hasClass('no-reset-on-submit')){
                        $(form).find('select').val('').trigger('change');
                    }

                    if($(form).hasClass('reloadPage')){
                        Shoot.reload(res.route, false); //false: halaman yang di reload jangan di scroll
                    }

                    App.scrollTo(error, -200);

                    if (typeof table !== "undefined") {
                        table.ajax.reload(null, true);
                    } else {
                        setTimeout(function() {
                            Shoot.reload(window.location.href);
                        }, 1500);
                        
                    }
                } else if (res.status == 0 || res.status == 2) { // Error Validasi dll
                    error.hide();

                    App.alert({
                        container: $('.alert-container', form),
                        place: 'append',
                        type: 'info',
                        message: res.message,
                        reset: true,
                        focus: true
                    });

                    if (res.toastr) {
                        toastr.error(res.toastr);
                    }
                } else if (res.status == 3) { // Error gagal insert
                    error.find('ul').html(res.message);
                    error.show();
                    App.scrollTo(error, -200);

                    App.alert({
                        container: $('.alert-container', form),
                        place: 'append',
                        type: 'warning',
                        message: res.message,
                        reset: true,
                        focus: true,
                    });
                } else if (res.status == 4) { // merah
                    error.find('ul').html(res.message);
                    error.show();
                    App.scrollTo(error, -200);

                    App.alert({
                        container: $('.alert-container', form),
                        place: 'append',
                        type: 'danger',
                        message: res.message,
                        reset: true,
                        focus: true,
                    });
                } else if (res.status == 5) {
                    Shoot.reload(res.route);
                } else if (res.status == 6) {
                    Shoot.reload(res.route, false); //Shoot.reload paramater keduanya itu apakah mau di scroll top / nggak
                }

                App.unblockUI(options.form);
            }

        },

        import: function(options, table, customCallback) {
            initForm(options, customCallback);
        }

    };

}();