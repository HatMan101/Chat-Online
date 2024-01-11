$(document).ready(function() {

    fetch_user();
    setInterval(function (){
        update_last_activity();
        fetch_user();
    }, 6000)

    function fetch_user() {
        $.ajax({
            url:"../global-resources/scripts/fetch_user.php",
            method:"POST",
            success:function(data){
                $('#userDetails').html(data);
            }
        })
    }

    function update_last_activity() {
        $.ajax({
            url:"../global-resources/scripts/update_last_activity.php",
            success:function(){

            }
        })
    }


    function chat_area(to_user_id, to_user_name) {
        $('#userDialog').attr({
            title: "You have a chat with " + to_user_name,
        })
        $('.chat_history').attr({
            touserid: to_user_id,
            id: "chat_history_" + to_user_id
        })
        $('.form-control').attr({
            name: "chat_message_" + to_user_id,
            id: "chat_message_" + to_user_id
        })
        $('.send_chat').attr({
            id: to_user_id
        })
    }
    $(document).on('click', '.start_chat', function() {
        let to_user_id = $(this).data('touserid');
        let to_user_name = $(this).data('tousername');
        chat_area(to_user_id, to_user_name);
    })

    $(document).on('click', '.send_chat', function() {
        let to_user_id = $(this).attr('id');
        let chat_message = $('#chat_message_' + to_user_id).val();
        console.log(to_user_id + chat_message);
        $.ajax({
            url: "../global-resources/scripts/insert_chat.php",
            method: "POST",
            data: {
                to_user_id: to_user_id,
                chat_message: chat_message
            },
            success:function(data) {
                $('#chat_message_' + to_user_id).val('');
                $('#chat_history_' + to_user_id).html(data);
            }
        })
    })
})