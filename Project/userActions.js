function follow(userTo, userFrom, button) {
    if(userTo == userFrom) {
        alert("You can't follow yourself");
        return;
    }

    $.post("ajax/follow.php", { userTo: userTo, userFrom: userFrom})
    .done(function(count) {
        if(count != null) {
            $(button).toggleClass("follow unfollow");

            if($(button).hasClass("follow")) {
                var buttonText = "FOLLOW";
            }
            else {
                var buttonText = "UNFOLLOW";
            }

            $(button).text(buttonText + " " + count);
        }
        else {
            alert("Something errored");
        }
    });
}