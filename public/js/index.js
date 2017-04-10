$('#flash-msg p span').on('click', function() {
    $('#flash-msg').fadeOut();
    $.ajax({
        url: '/index/unsetFlash',
        type: 'post',
        data: ''
    });
});

$(window).on('load', function() {
    setTimeout(function() {
        $('#flash-msg').fadeOut();
        $.ajax({
            url: '/index/unsetFlash',
            type: 'post',
            data: ''
        });
    }, 1 * 60 * 1000);
});

$('.close-box').on('click', function() {
    $(this).parent().remove();
});

$('.img-post').on('mouseover', function() {
    $(this).find('.img-likes').show();
}).on('mouseleave', function() {
    $(this).find('.img-likes').hide();
});

$('a.like').on('click', function(e) {
    e.preventDefault();
    var $this = $(this);

    like($this.parent().parent().attr('data-post-id'));

    if ($this.hasClass('liked')) {
        $this.removeClass('liked');
    } else {
        $this.addClass('liked');
    }
});

$('.posts .box').on('dblclick', function(e) {
    e.preventDefault();
    var $this = $(this);

    if (!$this.find('footer a.like').hasClass('liked')) {
        like($this.attr('data-post-id'));
    }

    $this.find('footer .like').addClass('liked');

    $this.find('.big-heart').show();
    setTimeout(function() {
        $this.find('.big-heart').addClass('click');
    }, 50);
    setTimeout(function() {
        $this.find('.big-heart').addClass('exit');
    }, 400);
    setTimeout(function() {
        $this.find('.big-heart').removeClass('click exit');
    }, 500);
});

$('.remove-avatar').on('click', function() {
    if (confirm('Tem certeza que deseja remover sua foto do perfil?')) {
        $('.avatar').css('background-image', 'url(/public/img/avatar.jpg)');
        $.ajax({
            url: '/remove/avatar',
            type: 'post',
            data: UID,
            dataType: 'json',
            success: function(data) {},
            error: function(data) {}
        });
    }
});

$('#upload-avatar').on('submit', function(e) {
    e.preventDefault();

    showLoading('Carregando...');

    $.ajax({
        url: '/upload/avatar',
        type: 'post',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            hideLoading();
            console.log(data);
            if (data.error) {
                $('.avatar-img').attr('src', '').hide();
                $('.add-avatar').show();
                alert(data.message);
            }
        },
        error: function(data) {
            console.error(data);
        }
    });
});

$('#upload-post').on('submit', function(e) {
    e.preventDefault();

    showLoading('Carregando...');

    $.ajax({
        url: '/upload/post',
        type: 'post',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            hideLoading();
            console.log(data);
            $('.post-img').css('background-image', '').hide();
            $('.btn-post').hide();
            $('.add-post').show();
            $('.click-to-post').removeClass('no-padding');

            if (data.error) {
                alert(data.message);
            } else {
                window.location.reload();
            }
        },
        error: function(data) {
            console.error(data);
        }
    });
});

function like(postId) {
    $post = $('[data-post-id=' + postId + ']');
    $footer = $post.find('footer');
    $aLike = $footer.find('a.like');
    $likes = $footer.find('p.likes');
    $span = $likes.find('span');
    i = $aLike.hasClass('liked') ? -1 : 1;
    totalLikes = parseInt($span.html().replace(/\./g, '')) + i;
    stringLikes = totalLikes.toString().split('').reverse().join('').replace(/(\d{3}(?!.*\.|$))/g, '$1.').split('').reverse().join('');
    $span.html(stringLikes);

    $.ajax({
        url: '/like',
        type: 'post',
        data: {p: postId},
        dataType: 'json'
    });
}

function excluirPost(postId) {
    $post = $('[data-post-id=' + postId + ']');
    imageSrc = '/public' + ( $post.find('div.post').css('background-image').replace('url(', '').replace(')', '').split('/public')[1] ).replace('"', '');

    showLoading();

    $.ajax({
        url: '/remove/post',
        type: 'post',
        data: {p: postId, uid: sUID, s: imageSrc},
        dataType: 'json',
        success: function(data) {
            hideLoading();
            if (data.error) {
                alert("Ocorreu um erro ao excluir o post. Por favor, tente novamente mais tarde.");
            } else {
                $post.fadeOut();
            }
        }
    });
}

function readURL(input, type) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        if (type == 'avatar') {
            reader.onload = function(e) {
                $('img.avatar-img').attr('src', e.target.result).show();
                $('.profile .avatar').css('background-image', 'url(' + e.target.result + ')');
                $('.add-avatar').hide();
            }

            reader.readAsDataURL(input.files[0]);
            $('#upload-avatar').submit();
        } else if (type == 'post') {
            reader.onload = function(e) {
                $('.click-to-post').addClass('no-padding');
                $('.post-img').css('background-image', 'url(' + e.target.result + ')').show();
                // $('.post').css('background-image', 'url(' + e.target.result + ')');
                $('.add-post').hide();
                $('.btn-post').show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
}

function showLoading(message) {
    $('#loading p').html(message);
    $('#loading').show();
}

function hideLoading() {
    $('#loading p').html('');
    $('#loading').hide();
}