function loginUser(user=false,password=false){
    return $.ajax({
        type:'POST',
        url:"cont.php",
        dataType: 'json',
        data:{param:"loginUser",base:"pruebas",user,password}
    });
}
function getAllReferenced(){
    return $.ajax({
        type:'POST',
        url:"cont.php",
        dataType: 'json',
        data:{param:"getAllReferenced",base:"pruebas"}
    });
}
function getUserLogged(){
    return $.ajax({
        type:'POST',
        url:"cont.php",
        dataType: 'json',
        data:{param:"getUserLogged",base:"pruebas"}
    });
}
function updateStatus(id_refer,status){
    return $.ajax({
        type:'POST',
        url:"cont.php",
        dataType: 'json',
        data:{param:"updateStatus",base:"pruebas",id_refer,status}
    });
}
function updateDiscount(id_refer,discount){
    return $.ajax({
        type:'POST',
        url:"cont.php",
        dataType: 'json',
        data:{param:"updateDiscount",base:"pruebas",id_refer,discount}
    });
}