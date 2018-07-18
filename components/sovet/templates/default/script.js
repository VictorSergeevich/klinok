$('#rating').rating({
	fx: 'half',
       image: '/files/stars.png',
       loader: '/files/ajax-loader.gif',
       click: function(data){
       	var rating = data;
       	var id = $(".detail").attr("data-id");
       	var votes_sum = $(".rating").attr("data-sum");
       	var votes_cnt = $(".rating").attr("data-cnt");
            var localrating = localStorage.getItem('localratings');
            var append_id = ","+id;

       	var form_data = {
       		"id": id,
       		"rating": rating,
       		"votes_sum": votes_sum,
       		"votes_cnt": votes_cnt,
       	};

            if(localrating && localrating.indexOf(append_id) + 1){
                 $(".vote-success").text("Вы уже голосовали за этот совет");
            }else{
            $.ajax({
                type: "POST", //Метод отправки
                url: "/ratingsovet.php", //путь до php фаила отправителя в соотвествии с роутером
                data: form_data,
                success: function(data) {
                        var localrating = localStorage.getItem('localratings');
                        var append_id = ","+id;
                        if(localrating){
                              if(localrating.indexOf(append_id) + 1){
                                    $(".vote-success").text("Вы уже голосовали за этот совет");
                              }else{
                                    var open_localrating = localrating + append_id;
                                    localStorage.setItem('localratings', open_localrating);                                    
                              }
                        }else{
                              localStorage.setItem('localratings', append_id);
                        }
                }
            });
            }
       }
});
