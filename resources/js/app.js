import 'bootstrap';
import 'jquery-pjax';
import autosize from 'autosize';
import 'owl.carousel';
import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel/dist/assets/owl.theme.default.min.css';
import 'moment';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';
import '../sass/app.scss';

// Create an instance of Notyf
const notyf = new Notyf({
    position: {
        x: 'right',
        y: 'top',
    },
    dismissible: true,
});

autosize(document.querySelectorAll('textarea'));

// owlcarousel2
$('.owl-carousel').owlCarousel({
    items: 1,
    lazyLoad: true,
    nav: true,
    dots: false
});

// document ready
$(function () {
    // follow/unfollow
    $(document).on('click', '#followUnfollowButton', function (e) {
        e.preventDefault();

        // follow/unfollow text
        let followUnfollowButton = $('#followUnfollowButton');

        if (followUnfollowButton.text().trim() === 'Follow') {
            followUnfollowButton.text('Unfollow');
        } else if (followUnfollowButton.text().trim() === 'Unfollow') {
            followUnfollowButton.text('Follow');
        }

        let username = $(this).data('username');
        let _url = '/follows/' + username;
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                _token: _token
            },
            success: function ({ data }) {
                $('#followersCount').text(data.followers_count)

                // notyf.success(data.message);
            },
            error: function (response) {
                notyf.error(response.responseJSON.message);
            }
        });
    });

    // like
    $(document).on('click', '.likeButton', function (e) {
        e.preventDefault();

        let postSlug = $(this).data('postSlug');
        let likeCount = $('#likeCount-' + postSlug);
        let _url = '/likes/' + postSlug;
        let _token = $('meta[name="csrf-token"]').attr('content');

        // change icon style
        $('#likeIcon-' + postSlug).toggleClass('far fas');

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                _token: _token
            },
            success: function ({ data }) {
                likeCount.text(data.likers_count);
                // notyf.success(data.message);
            },
            error: function (response) {
                notyf.error(response.responseJSON.message);
            }
        });
    });

    // comment store
    $(document).on('keyup', '.commentTextarea', function (e) {
        e.preventDefault();

        let postSlug = $(this).data('postSlug');
        let comment = $('#comment-' + postSlug).val();

        comment = comment.trim();
        if (comment.length > 0) {
            $('.commentButton').removeAttr('disabled');
            
            if (e.key === 'Enter' && !e.shiftKey) {
                let _url = '/comments';
                let _token = $('meta[name="csrf-token"]').attr('content');
                let commentAppend = window.user.commentAppend;
                
                $.ajax({
                    url: _url,
                    type: "POST",
                    data: {
                        post_slug: postSlug,
                        comment: comment,
                        _token: _token
                    },
                    success: function (data) {
                        if (commentAppend) {
                            $('#commentList-' + postSlug).append(data);
                        } else {
                            $('#commentList-' + postSlug).prepend(data);
                        }

                        $('#comment-' + postSlug).val('');

                        autosize.destroy(document.querySelectorAll('textarea'));

                        $('.commentButton').attr('disabled', 'disabled');

                        notyf.success('Comment added successfully!');
                    },
                    error: function (response) {
                        notyf.error(response.responseJSON.message);
                    }
                });
            }
        } else {
            $('.commentButton').attr('disabled', 'disabled');
        }
    });

    $(document).on('click', '.commentButton', function (e) {
        e.preventDefault();

        let postSlug = $(this).data('postSlug');
        let comment = $('#comment-' + postSlug).val();
        let _url = '/comments';
        let _token = $('meta[name="csrf-token"]').attr('content');
        let commentAppend = window.user.commentAppend;

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                post_slug: postSlug,
                comment: comment,
                _token: _token
            },
            success: function (data) {
                if (commentAppend) {
                    $('#commentList-' + postSlug).append(data);
                } else {
                    $('#commentList-' + postSlug).prepend(data);
                }

                $('#comment-' + postSlug).val('');

                autosize.destroy(document.querySelectorAll('textarea'));

                $('.commentButton').attr('disabled', 'disabled');

                notyf.success('Comment added successfully!');
            },
            error: function (response) {
                notyf.error(response.responseJSON.message);
            }
        });
    });

    // comment delete
    $(document).on('click', '.commentDeleteButton', function (e) {
        if (!confirm("Are you sure you want to delete?")) {
            return false;
        }

        e.preventDefault();

        let commentId = $(this).data('commentId');
        let _url = '/comments/' + commentId;
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "DELETE",
            data: {
                _token: _token
            },
            success: function (data) {
                $('#comment-' + commentId).remove();
                notyf.success(data.message);
            },
            error: function (response) {
                notyf.error(response.responseJSON.message);
            }
        });
    });

});