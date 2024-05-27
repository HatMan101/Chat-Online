

$(document).ready(function() {
    // Loads or repeats important functions
    fetch_user();
    setInterval(function (){
        update_last_activity();
        fetch_user();
    }, 6000)
    setInterval(function() {
        update_user_chat_history();
    }, 2500)
    $("textarea").keydown(enterKey);

    // Retrieves the other users
    function fetch_user() {
        $.ajax({
            url:"../global-resources/scripts/fetch_user.php",
            method:"POST",
            success:function(data){
                $('#userDetails').html(data);
            }
        })
    }

    // Updates your user activity
    function update_last_activity() {
        $.ajax({
            url:"../global-resources/scripts/update_last_activity.php",
            success:function() {}
        })
    }


    // Adds certain attributes, and fetches the chat history on-click of a user
    function chat_area(to_user_id, to_user_name) {
        $('#userDialog').attr({
            title: "You have a chat with " + to_user_name,
        })
        $('.chat_history').attr({
            "data-touserid": to_user_id,
            id: "chat_history_" + to_user_id,
        })
        $('.form-control').attr({
            name: "chat_message_" + to_user_id,
            id: "chat_message_" + to_user_id,
            "data-touserid": to_user_id
        })
        $('.send_chat').attr({
            id: to_user_id
        })
    }
    $(document).on('click', '.start_chat', function() {
        let to_user_id = $(this).data('touserid');
        let to_user_name = $(this).data('tousername');
        chat_area(to_user_id, to_user_name);
        fetch_user_chat_history(to_user_id);
        miniGame();
    })


    // On click of a user, retrieves the chat history and updates it in the chat area
    function fetch_user_chat_history(to_user_id) {
        $.ajax({
            url: "../global-resources/scripts/fetch_user_chat_history.php",
            method: "POST",
            data: {
                to_user_id: to_user_id
            },
            success:function(data) {
                $('#chat_history_' + to_user_id).html(data);
            }
        })
    }
    function update_user_chat_history() {
        $('.chat_history').each(function() {
            let to_user_id = $(this).attr('data-touserid');
            fetch_user_chat_history(to_user_id);
        })
    }


    // Func for enter key, when pressed send message. If shift isn't also pressed
    function enterKey(e) {
        if (e.type === 'keydown' && e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            let to_user_id = $(this).attr('data-touserid');
            let chat_message = $('textarea#chat_message_' + to_user_id).val();
            if (chat_message.length !== 0) {
                $.ajax({
                    url: "../global-resources/scripts/insert_chat.php",
                    method: "POST",
                    data: {
                        to_user_id: to_user_id,
                        chat_message: chat_message
                    },
                    success:function(data) {
                        $('textarea#chat_message_' + to_user_id).val('');
                        $('#chat_history_' + to_user_id).html(data);
                        // KANSKE MÅSTE SÄTTA #chat_history_ ISTÄLLET FÖR .chat_history_
                    }
                })
            } else {
                e.preventDefault();
            }
        }
    }
    // Shows weather or not the user is typing
    $(document).on('keydown', '.chat_message', function() {
        let is_type = 'yes';
        $.ajax({
            url: '../global-resources/scripts/update_is_type_status.php',
            method: 'POST',
            data: {
                is_type: is_type
            },
            success:function() {}
        })
    });
    $(document).on('blur', '.chat_message', function() {
        let is_type = 'no';
        $.ajax({
            url: '../global-resources/scripts/update_is_type_status.php',
            method: 'POST',
            data: {
                is_type: is_type
            },
            success:function() {}
        })
    });


    // Opens the add friends modal
    let addFriendsModal = document.getElementById('addFriendsModal');
    let closeFriendsModal = document.getElementById('closeFriendsModal');
    let errorMsg = document.getElementById('addModalErrorMsg');
    $(document).on('click', '#openFriendsModal', function() {
        addFriendsModal.style.display = "block";
        if (!errorMsg.classList.contains('invalid-feedback')) {
            errorMsg.classList.add('invalid-feedback');
        }
    })
    $(document).on('click', '#addFriendsModal',function(e) {
        if (e.target.contains(addFriendsModal) ||e.target === closeFriendsModal) {
            addFriendsModal.style.display = "none";
        }
    })

    // Searches for the user on add
    $(document).on('click', '#buttonAddUsername',function() {
        let input = document.getElementById('inputUsername').value.trim().split("#");
        if (input[0] === "" || input[1] === "" || isNaN(Number(input[1]))) {
            errorMsg.classList.remove('invalid-feedback');
            errorMsg.classList.add('feedback');
            return;
        } else {
            errorMsg.classList.remove('feedback');
            errorMsg.classList.add('invalid-feedback');
        }

        $.ajax({
            url: '../global-resources/scripts/add_friend_request.php',
            method: 'POST',
            data: {
                friend_username: input[0],
                friend_id: input[1]
            },
            success:function() {}
        })
    })

    // Friend request accept
    $(document).on('click', '.accept_friend_request', function() {
        let friend_id = $(this).attr('id');
        $.ajax({
            url: '../global-resources/scripts/accept_friend_request.php',
            method: 'POST',
            data: {
                friend_id: friend_id
            },
            success:function() {}
        })
    })
    // Friend request deny
    $(document).on('click', '.deny_friend_request', function() {
        let friend_id = $(this).attr('id');
        $.ajax({
            url: '../global-resources/scripts/accept_friend_request.php',
            method: 'POST',
            data: {
                friend_id: friend_id
            },
            success:function() {}
        })
    })


    function miniGame() {
        $.ajax({
            url: '../global-resources/components/4x4game/4x4gameSite.php',
            method: 'POST',
            success:function(data) {
                $('#miniGame').html(data);
            }
        })
    }
})