$(document).ready(function(){
        $('form').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'post',
            url: 'action.php',
            data: $('form').serialize(),
            success: function(data) {
                var json = $.parseJSON(data);
                if(typeof json['error'] != 'undefined'){
                    alert(json["error"]);
                }
                else {
                    $("p").html('');
                    $("p").append("Updated :"+json["updated"]);
                    $("input[name='currency']").val(json["currency"]);
                    $("input[name='bitcoin']").val(json["bitcoin"]);

                }
            }
          });

        });
    function populateLastMovements() {
        fetch.doPost('generate.php');
    }
    $("input[name='Generate']").click(populateLastMovements);

    var fetch = function() {
        return {
            doPost: function(src) {
                if (src)$.post(src, {gen:1},this.action);
                else throw new Error('No SRC was passed to getCounties!');
            },
            action:function (results)
            {
                var json = $.parseJSON(results);
                $("#table").find("tr:gt(0)").remove();
                $('#table').append("<tr><td>USD</td><td>"+json[0]["price"]+"</td><td>"+json[0]["change"]+"</td></tr>");
                $('#table').append("<tr><td>GBP</td><td>"+json[1]["price"]+"</td><td>"+json[1]["change"]+"</td></tr>");
                $('#table').append("<tr><td>EUR</td><td>"+json[2]["price"]+"</td><td>"+json[2]["change"]+"</td></tr>");
            }
        }

    }();


});
