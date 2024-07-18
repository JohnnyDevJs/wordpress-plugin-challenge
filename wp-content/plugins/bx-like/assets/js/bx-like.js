(function ($) {
    const origin = window.location.origin;
    const path = "/wp-content/plugins/bx-like/assets/images/";
    const thumb = "thumb.png";
    const image = `<img decoding="async" src="${origin}/${path}/${thumb}" />`;

    $(".like-dislike-buttons").on("click", ".like-button, .dislike-button", function () {
        const button = $(this);
        const post_id = button.data("post_id");
        const action_type = button.hasClass("like-button") ? "like" : "dislike";

        const top_liked_posts = $("#topLikedPosts")

        $.ajax({
            url: bx_like_ajax.ajax_url,
            type: "POST",
            data: { action: "update_like_dislike", post_id: post_id, action_type: action_type },
            success: function (response) {

                top_liked_posts.html(response.data.top_liked_posts)

                if (response.success) {
                    const buttons = button.closest(".like-dislike-buttons");
                    const like_button = buttons.find(".like-button");
                    const dislike_button = buttons.find(".dislike-button");
                    like_button.html("Like");
                    dislike_button.html("Dislike");

                    if (action_type === "like") {
                        like_button.attr("disabled", true).html("Liked" + image);
                        dislike_button.removeAttr("disabled").html("Dislike" + image);
                        document.cookie = `bx_like_${post_id}=${JSON.stringify({ like: true, dislike: false })}; path=/`;
                    } else {
                        dislike_button.attr("disabled", true).html("Dislike");
                        like_button.removeAttr("disabled").html("Like");
                        document.cookie = `bx_like_${post_id}=${JSON.stringify({ like: false, dislike: true })}; path=/`;
                    }

                } else {
                    alert(response.data.message || "Error updating like/dislike.");
                }

            },
            error: function () {
                alert("Error sending request.");
            },
        });


    });

    $(".like-dislike-buttons").each(function () {
        const post_id = $(this).find(".like-button").data("post_id");
        const cookie = document.cookie.split("; ").find((row) => row.startsWith(`bx_like_${post_id}`));

        if (cookie) {
            const status = JSON.parse(cookie.split("=")[1]);
            const like_button = $(this).find(".like-button");
            const dislike_button = $(this).find(".dislike-button");
            if (status.like) {
                like_button.html("Liked" + image);
                dislike_button.removeAttr("disabled");
                dislike_button.html("Dislike" + image);
            } else if (status.dislike) {
                dislike_button.attr("disabled", "disabled");
                dislike_button.html("Dislike");
                like_button.removeAttr("disabled").html("Like");
            }
        }
    });
})(jQuery);
