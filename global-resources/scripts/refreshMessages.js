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
        $('#user_dialog_').attr({
            title: 'You have a chat with ' + to_user_name,
        })

    }
    $(document).on('click', '.start_chat', function() {
        let to_user_id = $(this).data('touserid');
        let to_user_name = $(this).data('tousername');
        chat_area(to_user_id, to_user_name);
    })
})