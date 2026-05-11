app.controller('gameCtrl', function ($scope, $http, $log) {
    var TAB_MY_ACCOUNT_PROFILE = 'profile';
    var TAB_CASHIER_PAYMENT = 'payment'

    $scope.myAccountActiveTab = TAB_MY_ACCOUNT_PROFILE;
    $scope.cashierActiveTab = TAB_CASHIER_PAYMENT;
    $scope.levelActiveTab = TAB_CASHIER_PAYMENT;

    $scope.setActiveTab = function(e, name) {
        e.preventDefault();

        if (name === 'vip') {
            $('body').removeClass('overflow');
        } else {
            $('body').addClass('overflow');
        }

        if ($scope.myAccountActiveTab !== name) {
            $scope.myAccountActiveTab = name;
        }
    }

    $scope.isActiveTab = function(name) {
        return $scope.myAccountActiveTab === name;
    };

    $scope.setActiveSubTab = function(e, name) {
        e.preventDefault();
        if ($scope.cashierActiveTab !== name) {
            $scope.cashierActiveTab = name;
        }
    }

    $scope.isActiveSubTab = function(name) {
        return $scope.cashierActiveTab === name;
    };

    $scope.openModal = function(e, id) {
        e.preventDefault();
        
        $scope.closeModal(e);

        $(id).show();
        $('#lock__screen').show();
        $('body').addClass('overflow');
    }

    $scope.closeModal = function(e) {
        e.preventDefault();
        var $modal = $('.modal');

        $('input, textarea', $modal).removeClass('is__invalid');
        $('.invalid__feedback', $modal).remove();
        $('.modal__error, .modal-loading', $modal).hide();
        $modal.hide();
        $('#lock__screen').hide();
        $('body').removeClass('overflow');
    }

    $scope.sendForm = function(e) {
        e.preventDefault();

        var $form = $(e.target);
        var $modal = $form.closest('.modal');

        $('input, textarea', $form).removeClass('is__invalid');
        $('.invalid__feedback', $form).remove();
        $('.modal__error', $form).hide().text('');
        $('.modal-preloader', $modal).show();

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),
            success: function(data) {
                                $('.modal-preloader', $modal).hide();
                                $form.find("input, select, textarea").val("");
                
                if (data.link) {
                    location.replace(data.link);
                } else if ($form.data('modal-success')) {
                    $scope.openModal(e, $form.data('modal-success'));
                    
                    // Check if this is a demo account registration with credentials
                    var message = data[0];
                    var usernameMatch = message.match(/Username:\s*<strong>([^<]+)<\/strong>/);
                    var passwordMatch = message.match(/Password:\s*<strong>([^<]+)<\/strong>/);
                    
                    if (usernameMatch && passwordMatch) {
                        // This is a demo registration - show credentials in input fields
                        $("#demo-username-field").val(usernameMatch[1]);
                        $("#demo-password-field").val(passwordMatch[1]);
                        $("#demo-credentials-container").show();
                        $("#system-notification-success-text").html("<p style='color: #4CAF50; font-weight: bold;'>✓ Your demo account has been created successfully!</p>");
                    } else {
                        // Regular notification
                        $("#demo-credentials-container").hide();
                        $("#system-notification-success-text").html(message);
                    }
                } else {
                    location.reload();
                }
            },
            error: function (xhr) {
                var errors;
                
                try {
                    errors = JSON.parse(xhr.responseText);
                } catch(e) {
                    // If response is not JSON, show generic error
                    $('.modal__error', $form).show().text('An error occurred. Please try again.');
                    $('.modal-preloader', $modal).hide();
                    return;
                }

                $.each(errors, function (key, value) {
                    var field =  $('input[name="'+ key +'"], textarea[name="'+ key +'"]', $form)
                    if (field.length ) {
                        field.addClass('is__invalid')
                            .parent()
                            .append('<div class="invalid__feedback">'+ value[0] +'</div>');
                    } else {
                        $('.modal__error', $form).show().text(value);
                    }
                });

                $('.modal-preloader', $modal).hide();
            },
        });
    };
});

