function nice(store_id, elm){
    if(elm.classList.contains('active')){
        var url = `/sample-app-restaurant/public/store/deletenice/${store_id}`;
    } else{
        var url = `/sample-app-restaurant/public/store/nice/${store_id}`;
    }
    console.log(url);
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: url,
        type: "POST",
    })
        .done(function(data){
            console.log(data);
            // active が設定されていれば除去し、なければ追加
            elm.classList.toggle("active");
        })
        .fail(function(jqXHR, textStatus, errorThrown){
            console.log('失敗');
        });
}

// 写真のカルーセル
$('.autoplay').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: false,
    arrows: true,
});


