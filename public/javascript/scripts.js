(function(window, $, undefined) {

    "use strict";

    var photoPage = 0;
    var loadingPhoto = false;
    function loadNextPhotoPage()
    {
        if (loadingPhoto || $('.pagination-end').length) {
            return;
        }

        $('#photo-loader').show();

        var box = $('#list-photos');
        loadingPhoto = true;

        $.ajax({
            url: '/fotos/' + box.attr('data-username') + '?page=' + (photoPage + 1),
            success: function(response) {
                box.append(response);
            },
            complete: function() {
                loadingPhoto = false;
                $('#photo-loader').hide();
            }
        });

        photoPage++;
    }

    $(function() {

        $('#register-form').form({
            username: {
                identifier  : 'form-username',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Informe seu usuário'
                    }
                ]
            },
            email: {
                identifier  : 'form-email',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Informe seu e-mail'
                    },
                    {
                        type: 'email',
                        prompt: 'Informe um e-mail válido'
                    }
                ]
            },
            password: {
                identifier : 'form-password',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Informe sua senha'
                    },
                    {
                        type   : 'length[6]',
                        prompt : 'Sua senha precisa ter no mínimo 6 caracteres'
                    }
                ]
            }
        }, {
            inline : true,
            on     : 'blur'
        });

        $('#login-form').form({
            username: {
                identifier  : 'login-username',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Informe seu usuário'
                    }
                ]
            },
            password: {
                identifier : 'login-password',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Informe sua senha'
                    },
                    {
                        type   : 'length[6]',
                        prompt : 'Sua senha precisa ter no mínimo 6 caracteres'
                    }
                ]
            }
        }, {
            inline : true,
            on     : 'blur'
        });

        $('#send-photo-form').form({
            photo: {
                identifier  : 'form-photo',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Selecione uma imagem'
                    }
                ]
            },
            descriptin: {
                identifier : 'form-description',
                rules: [
                    {
                        type   : 'maxLength[140]',
                        prompt : 'Máximo de 140 caracteres'
                    }
                ]
            }
        }, {
            inline : true,
            on     : 'blur'
        });

        $(document).on('click', '.open-photo', function() {

            $(this).closest('.photo-item').children('.list-photo.modal').clone()
                .modal('setting', 'closable', true)
                .modal('show');

        });

        var followAjax = false;
        $('.follow').click(function() {

            if (followAjax) {
                return false;
            }

            followAjax = true;

            $.getJSON('/seguir/' + $(this).attr('data-username'), function(response) {
                window.location = window.location;
            });

        });

        var likeAjax = false;
        $(document).on('click', '.like-photo', function() {

            if (likeAjax) {
                return false;
            }

            likeAjax    = true;
            var obj     = $(this);
            var photoId = obj.attr('data-photo');

            $.getJSON('/curtir/' + photoId, function(response) {

                if (response.likes != undefined) {
                    $('.like-count', '.photo-' + photoId).text(response.likes + ' like\'s');
                }

                if (response.liked) {
                    obj.addClass('active');
                } else {
                    obj.removeClass('active');
                }

                likeAjax = false;
            });

        });

        if ($('#list-photos').length) {
            $(window).scroll(function () {
                if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                    loadNextPhotoPage();
                }
            });

            loadNextPhotoPage();
        }

    });

})(window, jQuery);