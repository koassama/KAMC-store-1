$(document).ready(function(){



  $('.mrejtle').change(function(){
      var id = $(this).val();
        $.ajax({
          url: 'fetch_dep.php',
          method : 'POST',
          data:  {id:id},
          success: function(data)
          {
            $('.lemth').html(data);

          }
        });
  })







// old
  $('#catef').change(function(){
      var id = $(this).val();
        $.ajax({
          url: 'fetch_subs.php',
          method : 'POST',
          data:  {id:id},
          success: function(data)
          {
            $('#98800d').html(data);

          }
        });
  })


    $('.rlul li a').removeClass('active');
    $(function () {
        var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
        $(".rlul li a").each(function () {
            if ($(this).attr("href") == pgurl) {
                $(this).closest('a').addClass("active");
            }
        })
    });
    $('.merelgj li a').removeClass('active');
    $(function () {
        var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
        $(".merelgj li a").each(function () {
            if ($(this).attr("href") == pgurl) {
                $(this).closest('a').addClass("active");
            }
        })
    });



    $(".animated-progress span").each(function () {
      $(this).animate(
        {
          width: $(this).attr("data-progress") + "%",
        },
        1000
      );
      // $(this).text($(this).attr("data-progress") + "%");
    });

  $('#comp').change(function(){
      var id = $(this).val();
        $.ajax({
          url: 'fetch_cars.php',
          method : 'POST',
          data:  {id:id},
          success: function(data)
          {
            $('#mdl').html(data);

          }
        });
  })
  setInterval(function() {
     online();
  }, 1000);

// function online(){
//   var time = $('#ttm').attr("time");
//   $.ajax({
//     url: 'insert_time.php',
//     method : 'POST',
//     data:  {time:time},
//     success: function(data)
//     {
//       $('#ttm').html(data);
//     }
//   });
// }
function online(){

  $.ajax({
    url: 'insert_time.php',
    method : 'POST',
    data:  $('#ttf').serialize(),
    success: function(data)
    {
      $('#ttm').html(data);
    }
  });
}

  $('#alr').click(function(){
    alert('?هل انت متاكد من انك قمت بارسال المنتج ');
  })


$('.up-ava').change(function(){

  $('#sb-bt').css('visibility', 'visible');
});




    $('#open-add-page').click(function(){
      $('#add-page').show();
    })

        $('#close').click(function(){
          $('#add-page').css('display', 'none');
        })



// ajax
$('#a-btn-option').click(function(){


  $.ajax({
    url: 'insert_user.php',
    method : 'POST',
    data:  $('#form-info').serialize(),
    success: function(data)
    {
      $('.err-msg').html(data);
    }
  });



});

$('#ca-btn-option').click(function(){


  $.ajax({
    url: 'insert_category.php',
    method : 'POST',
    data:  $('#ca-form-info').serialize(),
    success: function(data)
    {
      $('.err-msg').html(data);
    }
  });



});

$("#pro-btn-option").click(function(){

  var formData = new FormData("#pro-form-info");
    // Check file selected or not
alert(formData);

       $.ajax({
          url: 'insert_product.php',
          type: 'post',
          data: {formDate:formData},
          contentType: false,
          processData: false,
          success: function(data){
            $('#err-msg').html(data);
          }
       });

});


});


new Chartist.Line('.ct-chart', {
  labels: [1, 2, 3, 4, 5, 6, 7, 8],
  series: [
    [5, 9, 7, 8, 5, 3, 5, 4]
  ]
}, {
  low: 0,
  showArea: true
});


function tableone() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("users-search");
  filter = input.value.toUpperCase();
  table = document.getElementById("users-table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}




function tabletwo() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("categories-search");
  filter = input.value.toUpperCase();
  table = document.getElementById("categories-table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");

    if (td.length >= 2) { // Ensure there are at least 2 columns
      // Check the second column (رقم الجهاز) and the third column (رقم العهدة)
      var deviceNumber = td[1];  // رقم الجهاز
      var custodyNumber = td[2]; // رقم العهدة

      if (deviceNumber && custodyNumber) {
        txtValueDevice = deviceNumber.textContent || deviceNumber.innerText;
        txtValueCustody = custodyNumber.textContent || custodyNumber.innerText;

        // If either رقم الجهاز or رقم العهدة contains the search term
        if (txtValueDevice.toUpperCase().indexOf(filter) > -1 || txtValueCustody.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
}




function tablethree() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("movies-search");
  filter = input.value.toUpperCase();
  table = document.getElementById("movies-table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}



function tablefor() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("series-search");
  filter = input.value.toUpperCase();
  table = document.getElementById("series-table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

