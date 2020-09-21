function callMembers(group_id){
    $.ajax({
        url: 'php/sql.php',
        type:'post',
        data:{
            call_members:true,
            group_id:group_id
        },
        success:function(data){
            $('#member_tbl').html(data);
        },
        error:function(data){
            alert(data);
        }
    });
}

function sortList(member_id,old_level,new_level,group_id,sort_type){
    $.ajax({
        url: 'php/sql.php',
        type:'post',
        data:{
            sort:true,
            group_id:group_id,
            member_id:member_id,
            old_level:old_level,
            new_level:new_level,
            sort_type:sort_type
        },
        success:function(data){
            callMembers(group_id);
        },
        error:function(data){
            alert(data);
        }
    });
}